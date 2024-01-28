<?php

namespace App\Controllers;

use App\models\AlamModel; //Menggunakan file model yang bernama umumModel
use CodeIgniter\Exceptions\PageNotFoundException; //Menggunakan error handling

class databudaya extends BaseController // class umum merupakan varian dari BaseController
{
    protected $databudaya;
    function __construct()
    {
        $this->databudaya = new AlamModel();
    }

    public function index() //membuat fungsi index dengan sifat public
    {
   
        $databudaya = new AlamModel();


        $data['dataalamx'] = $databudaya->findAll();
        //mengirim data ke view
        echo view('databudaya', $data);
    }

    public function save() //membuat fungsi save dengan sifat public
    {
        if (!$this->validate([
            'antrian' => [
                'rules' => 'required|is_unique[tb_sedekah.antrian]',
                'errors' => [
                    'required' => 'silahkan isi no.antrian ',
                    'is_unique' => 'sudah ada {field} yang sama'
                ]
            ],
            'jenis' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'silahkan isi nama anda!'
                ]
            ],
            'nama' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} harus diisi!'
                ]
            ],
            'alamat' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} harus diisi!'
                ]
            ],
            'longlang' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} harus diisi!'
                ]
            ],
            'foto' => [
                'rules' => 'uploaded[foto]|max_size[foto,1024]|is_image[foto]|mime_in[foto,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'uploaded' => 'Pilih foto terlebih dahulu',
                    'max_size' => 'Ukuran foto terlalu besar',
                    'is_image' => 'Yang anda pilih bukan foto',
                    'mime_in'  => 'Yang anda pilih bukan foto'
                ]
            ],
            'info' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} harus diisi!'
                ]
            ],
           
           
        ])) {
            session()->setFlashdata('error', $this->validator->listErrors());
            return redirect()->back()->withInput();
        }

        $fileFoto = $this->request->getFile('foto');
        $fileFoto->move('foto');
        $namaFoto = $Foto->getName;

        $this->databudaya->insert([
            'antrian' => $this->request->getVar('antrian'),
            'jenis' => $this->request->getVar('jenis'),
            'nama' => $this->request->getVar('nama'),
            'alamat' => $this->request->getVar('alamat'),
            'longlang' => $this->request->getVar('longlang'),
            'foto' => $namaFoto,
            'info' => $this->request->getVar('info'),
            'status' => $this->request->getVar('status')
        ]);
        session()->setFlashdata('message', 'Data berhasil ditambahkan !');
        return redirect()->to('/databudaya');
    }



    function edit($antrian)
{
    $databudaya = $this->databudaya->find($antrian);
    if (empty($databudaya)) {
        throw new \CodeIgniter\Exceptions\PageNotFoundException('Data data sedekah tidak ditemukan !');
    }

    $data['databudaya'] = $databudaya;
    return view('databudaya-edit', $data);
}

public function saveEdit($antrian)
{
    if (!$this->validate([
        'antrian' => [
            'rules' => 'required|is_unique[tb_sedekah.antrian]',
            'errors' => [
                'required' => 'silahkan isi no.antrian ',
                'is_unique' => 'sudah ada {field} yang sama'
            ]
        ],
        'jenis' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'silahkan isi nama anda!'
            ]
        ],
        'nama' => [
            'rules' => 'required',
            'errors' => [
                'required' => '{field} harus diisi!'
            ]
        ],
        'alamat' => [
            'rules' => 'required',
            'errors' => [
                'required' => '{field} harus diisi!'
            ]
        ],
        'longlang' => [
            'rules' => 'required',
            'errors' => [
                'required' => '{field} harus diisi!'
            ]
        ],
        'foto' => [
            'rules' => 'uploaded[foto]|max_size[foto,1024]|is_image[foto]|mime_in[foto,image/jpg,image/jpeg,image/png]',
            'errors' => [
                'uploaded' => 'Pilih foto terlebih dahulu',
                'max_size' => 'Ukuran foto terlalu besar',
                'is_image' => 'Yang anda pilih bukan foto',
                'mime_in'  => 'Yang anda pilih bukan foto'
            ]
        ],
        'info' => [
            'rules' => 'required',
            'errors' => [
                'required' => '{field} harus diisi!'
            ]
        ],
    
])) {
    session()->setFlashdata('error', $this->validator->listErrors());
    return redirect()->back();
}

if (empty($this->request->getFile('foto')->getName())) {
    $namaFoto =  $this->request->getVar('old_foto');
} else {
    $fileFoto = $this->request->getFile('foto');
    //pindahkan file ke folder img
    $fileFoto->move('foto');
    //ambil nama file
    $namaFoto =  $fileFoto->getName();
    //  dd($fileFoto);

$this->databudaya->update($antrian, [
    'antrian' => $this->request->getVar('antrian'),
    'jenis' => $this->request->getVar('jenis'),
    'nama' => $this->request->getVar('nama'),
    'alamat' => $this->request->getVar('alamat'),
    'longlang' => $this->request->getVar('longlang'),
    'foto' => $namaFoto,
    'info' => $this->request->getVar('info'),
    'status' => $this->request->getVar('status')
]);
 session()->setFlashdata('message', 'Data Nasabah berhasil diperbaikin !');
    return redirect()->to('/databudaya');
}

function delete($antrian)
{
    $databudaya = $this->databudaya->find($id);
    if (empty($databudaya)) {
        throw new \CodeIgniter\Exceptions\PageNotFoundException('Data wisata tidak ditemukan !');
    }
    $this->databudaya->delete($id);
    session()->setFlashdata('message', 'Berhasil menghapus data wisata !');
    return redirect()->to('/databudaya');
}

}



}