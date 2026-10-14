<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Users extends BaseController
{
    public function index()
    {
        $model = new UserModel();

        return view('users', ['users' => $model->orderBy('id', 'ASC')->findAll()]);
    }

    public function newForm()
    {
        return view('users/new');
    }

    public function create()
    {
        $rules = [
            'username'  => 'required|max_length[50]|is_unique[users.username]',
            'full_name' => 'required|max_length[100]',
            'role'      => 'required|max_length[30]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->to(site_url('users/new'))->withInput();
        }

        $model = new UserModel();
        $model->insert([
            'username'   => $this->request->getPost('username'),
            'full_name'  => $this->request->getPost('full_name'),
            'role'       => $this->request->getPost('role'),
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to(site_url('users'));
    }

    public function edit(int $id)
    {
        $model = new UserModel();
        $user = $model->find($id);

        if ($user === null) {
            throw PageNotFoundException::forPageNotFound();
        }

        return view('users/edit', ['user' => $user]);
    }

    public function update(int $id)
    {
        $model = new UserModel();
        if ($model->find($id) === null) {
            throw PageNotFoundException::forPageNotFound();
        }

        $file = $this->request->getFile('avatar');
        $hasUpload = $file !== null && $file->getError() !== UPLOAD_ERR_NO_FILE;

        $rules = [
            'username'  => 'required|max_length[50]|is_unique[users.username,id,' . $id . ']',
            'full_name' => 'required|max_length[100]',
            'role'      => 'required|max_length[30]',
        ];

        if ($hasUpload) {
            $rules['avatar'] = 'uploaded[avatar]|max_size[avatar,2048]|mime_in[avatar,image/jpeg,image/png]|ext_in[avatar,jpg,jpeg,png]';
        }

        if (! $this->validate($rules)) {
            return redirect()->to(site_url('users/' . $id . '/edit'))->withInput();
        }

        $data = [
            'username'  => $this->request->getPost('username'),
            'full_name' => $this->request->getPost('full_name'),
            'role'      => $this->request->getPost('role'),
        ];

        if ($hasUpload) {
            $uploadPath = FCPATH . 'uploads';
            $newName = $file->getRandomName();
            $filePath = $uploadPath . DIRECTORY_SEPARATOR . $newName;

            try {
                if (! is_dir($uploadPath) && ! mkdir($uploadPath, 0775, true)) {
                    throw new \RuntimeException('Unable to create the uploads directory.');
                }

                $file->move($uploadPath, $newName);
                $image = service('image');
                $saved = $image->withFile($filePath)->fit(300, 300, 'center')->save($filePath);
                if (! $saved) {
                    throw new \RuntimeException('Unable to prepare the avatar image.');
                }
            } catch (\Throwable $error) {
                if (is_file($filePath)) {
                    unlink($filePath);
                }

                log_message('error', 'Avatar upload failed: ' . $error->getMessage());
                return redirect()->to(site_url('users/' . $id . '/edit'))
                    ->withInput()
                    ->with('upload_error', 'The image could not be saved. Please try another JPG or PNG.');
            }

            $data['avatar'] = $newName;
        }

        $model->update($id, $data);

        return redirect()->to(site_url('users'));
    }
}
