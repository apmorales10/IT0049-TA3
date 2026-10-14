<?php

namespace App\Controllers;

use App\Models\CustomerModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Customers extends BaseController
{
    public function index()
    {
        $model = new CustomerModel();

        return view('customers', ['customers' => $model->orderBy('id', 'ASC')->findAll()]);
    }

    public function newForm()
    {
        return view('customers/new');
    }

    public function create()
    {
        $rules = [
            'full_name' => 'required|max_length[100]',
            'email'     => 'required|valid_email|max_length[100]',
            'phone'     => 'permit_empty|max_length[20]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->to(site_url('customers/new'))->withInput();
        }

        $model = new CustomerModel();
        $model->insert([
            'full_name'  => $this->request->getPost('full_name'),
            'email'      => $this->request->getPost('email'),
            'phone'      => $this->request->getPost('phone'),
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to(site_url('customers'));
    }

    public function edit(int $id)
    {
        $model = new CustomerModel();
        $customer = $model->find($id);

        if ($customer === null) {
            throw PageNotFoundException::forPageNotFound();
        }

        return view('customers/edit', ['customer' => $customer]);
    }

    public function update(int $id)
    {
        $model = new CustomerModel();
        if ($model->find($id) === null) {
            throw PageNotFoundException::forPageNotFound();
        }

        $rules = [
            'full_name' => 'required|max_length[100]',
            'email'     => 'required|valid_email|max_length[100]',
            'phone'     => 'permit_empty|max_length[20]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->to(site_url('customers/' . $id . '/edit'))->withInput();
        }

        $model->update($id, [
            'full_name' => $this->request->getPost('full_name'),
            'email'     => $this->request->getPost('email'),
            'phone'     => $this->request->getPost('phone'),
        ]);

        return redirect()->to(site_url('customers'));
    }
}
