<?php
namespace App\Controllers;

use App\Models\ArchiveModel;
use App\Models\CategoryModel;

class Category extends BaseController
{
    protected CategoryModel $categories;

    public function __construct()
    {
        $this->categories = new CategoryModel();
    }

    public function index()
    {
        return view('categories/index', ['categories' => $this->categories->orderBy('name')->findAll()]);
    }

    public function create()
    {
        return view('categories/form', ['category' => null]);
    }

    public function store()
    {
        if (! $this->validate(['name' => 'required|min_length[2]|max_length[100]|is_unique[categories.name]'])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        $this->categories->insert(['name' => trim($this->request->getPost('name'))]);
        return redirect()->to('/categories')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $category = $this->categories->find($id);
        if (! $category) {
            return redirect()->to('/categories')->with('error', 'Kategori tidak ditemukan.');
        }
        return view('categories/form', ['category' => $category]);
    }

    public function update($id)
    {
        if (! $this->categories->find($id)) {
            return redirect()->to('/categories')->with('error', 'Kategori tidak ditemukan.');
        }
        if (! $this->validate(['name' => "required|min_length[2]|max_length[100]|is_unique[categories.name,id,{$id}]"])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        $this->categories->update($id, ['name' => trim($this->request->getPost('name'))]);
        return redirect()->to('/categories')->with('success', 'Kategori berhasil diperbarui.');
    }

    public function delete($id)
    {
        if ((new ArchiveModel())->where('category_id', $id)->countAllResults() > 0) {
            return redirect()->to('/categories')->with('error', 'Kategori tidak dapat dihapus karena masih dipakai arsip.');
        }
        $this->categories->delete($id);
        return redirect()->to('/categories')->with('success', 'Kategori berhasil dihapus.');
    }
}
