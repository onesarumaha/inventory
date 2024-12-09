<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Omset as ModelsOmset;
use App\Models\Stock;
use App\Models\Users;
use CodeIgniter\HTTP\ResponseInterface;
use Dompdf\Dompdf;
use Dompdf\Options;

class Omset extends BaseController
{
    public function index()
    {
        $user = user();
        $role = $user->role;
        $userId = $user->id; 
    
        if (!is_array($role)) {
            $role = [$role];
        }
    
        $query = new ModelsOmset();
    
        if (in_array('petugas', $role)) {
            $omset = $query->getProductByPetugas($userId);
        } else {
            $omset = $query->getProduct();
        }
    
        $totalOmset = array_sum(array_column($omset, 'omset'));
    
        $userModel = new Users();
        $petugas = $userModel->getPetugas();
    
        $data = [
            'title' => 'Laporan Penjualan',
            'omsets' => $omset,
            'petugas' => $petugas,
            'totalOmset' => $totalOmset,
        ];
    
        return view('laporan/omset', $data);
    }
    

    public function filter()
    {
        $omsetModel = new ModelsOmset();
        $startDate = $this->request->getGet('startDate');
        $endDate = $this->request->getGet('endDate');
        $petugasId = $this->request->getGet('petugasId');

        $query = $omsetModel->select('date, product_id, quantity, omset, type');

        $query = $omsetModel->select('laporan.*, product.name as product_name')
                                ->where('laporan.type', 'out')
                                ->join('product', 'product.id = laporan.product_id');

        if ($startDate) {
            $query->where('date >=', $startDate);
        }
        if ($endDate) {
            $query->where('date <=', $endDate);
        }
        if ($petugasId) {
            $query->where('user_id', $petugasId);
        }

        $omsets = $query->findAll();

        $totalOmset = array_sum(array_column($omsets, 'omset'));

        return $this->response->setJSON([
            'data' => $omsets,
            'totalOmset' => $totalOmset,
        ]);
    }

    public function exportDataOmset()
    {
        $request = $this->request->getGet();
    
        $startDate = $request['startDate'] ?? null;
        $endDate = $request['endDate'] ?? null;
        $petugasId = $request['petugasId'] ?? null;
    
        $model = new ModelsOmset();
    
        $query = $model->select('date, product_id, quantity, omset, type');

        $query = $model->select('laporan.*, product.name as product_name')
                                ->where('laporan.type', 'out')
                                ->join('product', 'product.id = laporan.product_id');
    
        if ($startDate) {
            $query->where('date >=', $startDate);
        }
        if ($endDate) {
            $query->where('date <=', $endDate);
        }
        if ($petugasId) {
            $query->where('user_id', $petugasId);
        }
  
    
        $data = $query->findAll();
    
        $action = $request['action'] ?? 'excel';
    
        if ($action === 'excel') {
            // Export ke Excel
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment; filename="data_omset.xls"');
            echo "Date\tProduct\tQuantity\tOmset\n";
            foreach ($data as $row) {
                echo "{$row['date']}\t{$row['product_name']}\t{$row['quantity']}\t{$row['omset']}\n";
            }
            exit;
        } elseif ($action === 'pdf') {
            $dompdf = new Dompdf();
            $options = new Options();
            $options->set('isHtml5ParserEnabled', true);
            $options->set('isPhpEnabled', true);
            $dompdf->setOptions($options);
            $totalOmset = 0;
                foreach ($data as $row) {
                $totalOmset += $row['omset'];
            }

                
        $html = '
        <html>
        <head>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    margin: 20px;
                }
                h3, h4 {
                    text-align: center;
                }
                table {
                    width: 100%;
                    border-collapse: collapse;
                    margin-top: 20px;
                }
                th, td {
                    border: 1px solid #000;
                    padding: 8px;
                    text-align: center;
                }
                th {
                    background-color: #f2f2f2;
                    font-weight: bold;
                }
                td {
                    text-align: right;
                }
                .table-header {
                    text-align: center;
                    font-weight: bold;
                }
                .center {
                    text-align: center;
                    display: block;
                    }
                .total {
                        text-align: right;
                        font-weight: bold;
                        margin-top: 20px;
                    }
            </style>
        </head>
        <body>
            <h3>Laporan Penjualan</h3>
            <h4>PT. ALPHA KUMALA WARDHANA JAKARTA</h4>
            <label class="center">Start Date: ' . date('d-m-Y', strtotime($startDate)) . '</label> <br>
            <label class="center">End Date: ' . date('d-m-Y', strtotime($endDate)) . '</label>
            <table>
                <thead>
                    <tr>
                        <th class="table-header">Date</th>
                        <th class="table-header">Product</th>
                        <th class="table-header">Quantity</th>
                        <th class="table-header">Omset</th>
                    </tr>
                </thead>
                <tbody>';
            
                foreach ($data as $row) {
                    $html .= "<tr>
                                <td>" . date('d-m-Y H:s:i' , strtotime($row['date'])) . "</td>
                                <td>{$row['product_name']}</td>
                                <td>{$row['quantity']}</td>
                                <td>Rp. " . number_format($row['omset'], 0, ',', '.') . "</td>
                            </tr>";
                }
                
        $html .= '</tbody>
                </table>
        
                <div class="total">
                    <label>Total Omset: Rp. ' . number_format($totalOmset, 0, ',', '.') . '</label>
                </div>
            </body>
            </html>';
    
            $dompdf->loadHtml($html);
    
            $dompdf->setPaper('A4', 'portrait');
    
            $dompdf->render();
    
            $dompdf->stream("omset_report.pdf", array("Attachment" => 0));
        }
    
        exit;
    }

    public function pengadaan()
    {
        $user = user();
        $role = $user->role;
        $userId = $user->id; 
    
        if (!is_array($role)) {
            $role = [$role];
        }
    
        $query = new ModelsOmset();
    
        if (in_array('petugas', $role)) {
            $omset = $query->getPengadaanPetugas($userId);
        } else {
            $omset = $query->getLaporanPetugas();
        }
    
        $totalOmset = array_sum(array_column($omset, 'omset'));
    
        $userModel = new Users();
        $petugas = $userModel->getPetugas();
    
        $data = [
            'title' => 'Laporan Pengadaan',
            'omsets' => $omset,
            'petugas' => $petugas,
            'totalOmset' => $totalOmset,
        ];
    
        return view('laporan/pengadaan', $data);
    }

    public function filterPengadaan()
    {
        $omsetModel = new ModelsOmset();
        $startDate = $this->request->getGet('startDate');
        $endDate = $this->request->getGet('endDate');
        $petugasId = $this->request->getGet('petugasId');

        $query = $omsetModel->select('date, product_id, quantity, omset, type');

        $query = $omsetModel->select('laporan.*, product.name as product_name')
                                ->where('laporan.type', 'in')
                                ->join('product', 'product.id = laporan.product_id');

        if ($startDate) {
            $query->where('date >=', $startDate);
        }
        if ($endDate) {
            $query->where('date <=', $endDate);
        }
        if ($petugasId) {
            $query->where('user_id', $petugasId);
        }
    

        $omsets = $query->findAll();

        $totalOmset = array_sum(array_column($omsets, 'omset'));

        return $this->response->setJSON([
            'data' => $omsets,
            'totalOmset' => $totalOmset,
        ]);
    }

    public function exportDataOmsetPengadaan()
    {
        $request = $this->request->getGet();
    
        $startDate = $request['startDate'] ?? null;
        $endDate = $request['endDate'] ?? null;
        $petugasId = $request['petugasId'] ?? null;
    
        $model = new ModelsOmset();
    
        $query = $model->select('date, product_id, quantity, omset, type');

        $query = $model->select('laporan.*, product.name as product_name')
                                ->where('laporan.type', 'in')
                                ->join('product', 'product.id = laporan.product_id');
    
        if ($startDate) {
            $query->where('date >=', $startDate);
        }
        if ($endDate) {
            $query->where('date <=', $endDate);
        }
        if ($petugasId) {
            $query->where('user_id', $petugasId);
        }
    
    
        $data = $query->findAll();
    
        $action = $request['action'] ?? 'excel';
    
        if ($action === 'excel') {
            // Export ke Excel
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment; filename="data_omset.xls"');
            echo "Date\tProduct\tQuantity\tOmset\n";
            foreach ($data as $row) {
                echo "{$row['date']}\t{$row['product_name']}\t{$row['quantity']}\t{$row['omset']}\n";
            }
            exit;
        } elseif ($action === 'pdf') {
            $dompdf = new Dompdf();
            $options = new Options();
            $options->set('isHtml5ParserEnabled', true);
            $options->set('isPhpEnabled', true);
            $dompdf->setOptions($options);
            $totalOmset = 0;
                foreach ($data as $row) {
                $totalOmset += $row['omset'];
            }

                
        $html = '
        <html>
        <head>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    margin: 20px;
                }
                h3, h4 {
                    text-align: center;
                }
                table {
                    width: 100%;
                    border-collapse: collapse;
                    margin-top: 20px;
                }
                th, td {
                    border: 1px solid #000;
                    padding: 8px;
                    text-align: center;
                }
                th {
                    background-color: #f2f2f2;
                    font-weight: bold;
                }
                td {
                    text-align: right;
                }
                .table-header {
                    text-align: center;
                    font-weight: bold;
                }
                .center {
                    text-align: center;
                    display: block;
                    }
                .total {
                        text-align: right;
                        font-weight: bold;
                        margin-top: 20px;
                    }
            </style>
        </head>
        <body>
            <h3>Laporan Pengadaan</h3>
            <h4>PT. ALPHA KUMALA WARDHANA JAKARTA</h4>
            <label class="center">Start Date: ' . date('d-m-Y', strtotime($startDate)) . '</label> <br>
            <label class="center">End Date: ' . date('d-m-Y', strtotime($endDate)) . '</label>
            <table>
                <thead>
                    <tr>
                        <th class="table-header">Date</th>
                        <th class="table-header">Product</th>
                        <th class="table-header">Quantity</th>
                        <th class="table-header">Omset</th>
                    </tr>
                </thead>
                <tbody>';
            
                foreach ($data as $row) {
                    $html .= "<tr>
                                <td>" . date('d-m-Y H:s:i' , strtotime($row['date'])) . "</td>
                                <td>{$row['product_name']}</td>
                                <td>{$row['quantity']}</td>
                                <td>Rp. " . number_format($row['omset'], 0, ',', '.') . "</td>
                            </tr>";
                }
                
        $html .= '</tbody>
                </table>
        
                <div class="total">
                    <label>Total Omset: Rp. ' . number_format($totalOmset, 0, ',', '.') . '</label>
                </div>
            </body>
            </html>';
    
            $dompdf->loadHtml($html);
    
            $dompdf->setPaper('A4', 'portrait');
    
            $dompdf->render();
    
            $dompdf->stream("omset_report.pdf", array("Attachment" => 0));
        }
    
        exit;
    }


}
