<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Stock as ModelsStock;
use App\Models\Users;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\Omset as ModelsOmset;
use Dompdf\Dompdf;
use Dompdf\Options;

class Stock extends BaseController
{
    public function index()
    {
        $user = user(); 
        $role = $user->role; 
    
        if (!is_array($role)) {
            $role = [$role];
        }
    
        $query = new ModelsStock();
    
        if (in_array('petugas', $role)) {
            $stock = $query->getProductByPetugas($user->id);
        } else {
            $stock = $query->getProduct();
    
        }
    
        $userModel = new Users();
        $petugas = $userModel->getPetugas();
    
        $data = [
            'title' => 'Laporan Stock Barang',
            'stocks' => $stock,
            'petugas' => $petugas,
        ];
    
        return view('laporan/stock', $data);    
    }

    public function filter()
    {
        if ($this->request->isAJAX()) {
            $stockModel = new ModelsStock();
            $startDate = $this->request->getGet('startDate');
            $endDate = $this->request->getGet('endDate');
            $petugasId = $this->request->getGet('petugasId');
            $type = $this->request->getGet('type');
    
            $query = $stockModel->select('laporan.*, product.name as product_name')
                                ->join('product', 'product.id = laporan.product_id')
                                ->where('type', $type)
                                ->where('date >=', $startDate)
                                ->where('date <=', $endDate);
    
            if (!empty($petugasId) && $petugasId !== 'Pilih Petugas') {
                $query->where('user_id', $petugasId);
            }
    
            $filteredStocks = $query->findAll();
    
            return $this->response->setJSON($filteredStocks);
        }
    }

    public function exportDataStock()
    {
        $request = $this->request->getGet();
    
        $startDate = $request['startDate'] ?? null;
        $endDate = $request['endDate'] ?? null;
        $petugasId = $request['petugasId'] ?? null;
        $type = $request['type'] ?? null;
    
        $model = new ModelsOmset();
    
        $query = $model->select('date, product_id, quantity, omset, type');

        $query = $model->select('laporan.*, product.name as product_name')
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

        if ($type) {
            $query->where('type', $type);
        }
  
    
        $data = $query->findAll();
    
        $action = $request['action'] ?? 'excel';
    
        if ($action === 'excel') {
            // Export ke Excel
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment; filename="data_omset.xls"');
            echo "Date\tProduct\tQuantity\tType\n";
            foreach ($data as $row) {
                echo "{$row['date']}\t{$row['product_name']}\t{$row['quantity']}\t{$row['type']}\n";
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
            <h3>Laporan Stock</h3>
            <h4>PT. ALPHA KUMALA WARDHANA JAKARTA</h4>
            <label class="center">Start Date: ' . date('d-m-Y', strtotime($startDate)) . '</label> <br>
            <label class="center">End Date: ' . date('d-m-Y', strtotime($endDate)) . '</label>
            <table>
                <thead>
                    <tr>
                        <th class="table-header">Date</th>
                        <th class="table-header">Product</th>
                        <th class="table-header">Quantity</th>
                        <th class="table-header">Type</th>
                    </tr>
                </thead>
                <tbody>';
            
                foreach ($data as $row) {
                    $html .= "<tr>
                                <td>" . date('d-m-Y H:s:i' , strtotime($row['date'])) . "</td>
                                <td>{$row['product_name']}</td>
                                <td>{$row['quantity']}</td>
                                <td>{$row['type']}</td>
                            </tr>";
                }
                
        $html .= '</tbody>
                </table>
        
              
            </body>
            </html>';
    
            $dompdf->loadHtml($html);
    
            $dompdf->setPaper('A4', 'portrait');
    
            $dompdf->render();
    
            $dompdf->stream("stock_report.pdf", array("Attachment" => 0));
        }
    
        exit;
    }

    


}
