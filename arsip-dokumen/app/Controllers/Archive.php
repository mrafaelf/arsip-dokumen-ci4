<?php
namespace App\Controllers;

use App\Models\ArchiveModel;
use App\Models\CategoryModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Archive extends BaseController
{
    protected ArchiveModel $archives;
    protected string $uploadPath;

    private const FILE_RULES = 'max_size[file,5120]|ext_in[file,pdf,jpg,jpeg,png]|mime_in[file,application/pdf,image/jpg,image/jpeg,image/png]';

    public function __construct()
    {
        $this->archives   = new ArchiveModel();
        $this->uploadPath = WRITEPATH . 'uploads/archives/';
    }

    public function index()
    {
        $q   = trim((string) $this->request->getGet('q'));
        $cat = $this->request->getGet('category');

        $builder = $this->archives->withCategory()->orderBy('archives.created_at', 'DESC');
        if ($q !== '') { $builder->like('archives.title', $q); }
        if ($cat)      { $builder->where('archives.category_id', $cat); }

        return view('archives/index', [
            'archives'   => $builder->paginate(10),
            'pager'      => $this->archives->pager,
            'categories' => (new CategoryModel())->orderBy('name')->findAll(),
            'q'          => $q,
            'cat'        => $cat,
        ]);
    }

    public function create()
    {
        return view('archives/form', [
            'archive'    => null,
            'categories' => (new CategoryModel())->orderBy('name')->findAll(),
        ]);
    }

    public function store()
    {
        $rules = [
            'title'       => 'required|min_length[3]|max_length[200]',
            'category_id' => 'required|is_natural_no_zero|is_not_unique[categories.id]',
            'description' => 'permit_empty|max_length[2000]',
            'file'        => 'uploaded[file]|' . self::FILE_RULES,
        ];
        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $file = $this->request->getFile('file');
        $name = $file->getRandomName();
        $meta = ['type' => $file->getClientMimeType(), 'size' => $file->getSize(), 'orig' => $file->getClientName()];
        $file->move($this->uploadPath, $name);

        $this->archives->insert([
            'title'         => trim($this->request->getPost('title')),
            'category_id'   => $this->request->getPost('category_id'),
            'description'   => $this->request->getPost('description') ?: null,
            'file_name'     => $name,
            'original_name' => $meta['orig'],
            'file_type'     => $meta['type'],
            'file_size'     => $meta['size'],
        ]);

        return redirect()->to('/archives')->with('success', 'Arsip berhasil ditambahkan.');
    }

    public function show($id)
    {
        $archive = $this->archives->withCategory()->where('archives.id', $id)->first();
        if (! $archive) {
            return redirect()->to('/archives')->with('error', 'Arsip tidak ditemukan.');
        }
        return view('archives/show', ['archive' => $archive]);
    }

    public function edit($id)
    {
        $archive = $this->archives->find($id);
        if (! $archive) {
            return redirect()->to('/archives')->with('error', 'Arsip tidak ditemukan.');
        }
        return view('archives/form', [
            'archive'    => $archive,
            'categories' => (new CategoryModel())->orderBy('name')->findAll(),
        ]);
    }

    public function update($id)
    {
        $archive = $this->archives->find($id);
        if (! $archive) {
            return redirect()->to('/archives')->with('error', 'Arsip tidak ditemukan.');
        }

        $rules = [
            'title'       => 'required|min_length[3]|max_length[200]',
            'category_id' => 'required|is_natural_no_zero|is_not_unique[categories.id]',
            'description' => 'permit_empty|max_length[2000]',
            'file'        => self::FILE_RULES, // opsional saat edit
        ];
        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'title'       => trim($this->request->getPost('title')),
            'category_id' => $this->request->getPost('category_id'),
            'description' => $this->request->getPost('description') ?: null,
        ];

        $file = $this->request->getFile('file');
        if ($file && $file->isValid() && ! $file->hasMoved()) {
            $name = $file->getRandomName();
            $data['file_type']     = $file->getClientMimeType();
            $data['file_size']     = $file->getSize();
            $data['original_name'] = $file->getClientName();
            $data['file_name']     = $name;
            $file->move($this->uploadPath, $name);
            $this->removeFile($archive['file_name']);
        }

        $this->archives->update($id, $data);
        return redirect()->to('/archives')->with('success', 'Arsip berhasil diperbarui.');
    }

    public function delete($id)
    {
        $archive = $this->archives->find($id);
        if ($archive) {
            $this->removeFile($archive['file_name']);
            $this->archives->delete($id);
        }
        return redirect()->to('/archives')->with('success', 'Arsip berhasil dihapus.');
    }

    /** Lihat dokumen langsung di browser (PDF/gambar) */
    public function file($id)
    {
        [$archive, $path] = $this->locate($id);
        return $this->response
            ->setHeader('Content-Type', $archive['file_type'])
            ->setHeader('Content-Disposition', 'inline; filename="' . $archive['original_name'] . '"')
            ->setBody(file_get_contents($path));
    }

    /** Unduh dokumen */
    public function download($id)
    {
        [$archive, $path] = $this->locate($id);
        return $this->response->download($path, null)->setFileName($archive['original_name']);
    }

    private function locate($id): array
    {
        $archive = $this->archives->find($id);
        $path    = $archive ? $this->uploadPath . $archive['file_name'] : '';
        if (! $archive || ! is_file($path)) {
            throw PageNotFoundException::forPageNotFound('File tidak ditemukan.');
        }
        return [$archive, $path];
    }

    private function removeFile(string $name): void
    {
        $path = $this->uploadPath . $name;
        if (is_file($path)) { unlink($path); }
    }
}
