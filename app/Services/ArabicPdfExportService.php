<?php

namespace App\Services;

use Elibyy\TCPDF\TCPDF;

class ArabicPdfExportService
{
    public function exportUsers($users)
    {
        $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);

        // Set document information
        $pdf->SetCreator(config('app.name'));
        $pdf->SetAuthor(config('app.name'));
        $pdf->SetTitle('قانون المستخدمين');
        $pdf->SetSubject('بيانات المستخدمين');

        // Set margins (left, top, right)
        $pdf->SetMargins(15, 40, 15);
        $pdf->SetHeaderMargin(5);
        $pdf->SetFooterMargin(10);
        $pdf->SetAutoPageBreak(true, 25);

        // Set Arabic support
        $pdf->setRTL(true);
        $pdf->SetFont('aealarabiya', '', 12);

        // Add a page
        $pdf->AddPage();

        // Draw page border (5mm margin)
        $borderMargin = 5;
        $pdf->Rect(
            $borderMargin, 
            $borderMargin, 
            $pdf->getPageWidth() - 2*$borderMargin, 
            $pdf->getPageHeight() - 2*$borderMargin
        );

        // Add logo (30x30 pixels at top right)
        $logoPath = public_path('images/logo.png');
        if (file_exists($logoPath)) {
            $pdf->Image(
                $logoPath, 
                50,       // X position (right side)
                10,        // Y position (10mm from top)
                30,        // Width (30px)
                30,        // Height (30px)
                'PNG'
            );
        }

        // Generate HTML content
        $html = $this->generateArabicHtml($users);

        // Write HTML content
        $pdf->writeHTML($html, true, false, true, false, '');

        // Output the PDF
        return $pdf->Output('users-list.pdf', 'D');
    }

    protected function generateArabicHtml($users)
    {
        $html = '
        <style>
            .header {
                text-align: center;
                font-size: 18px;
                font-weight: bold;
                margin-bottom: 15px;
            }
            table {
                width: 100%;
                border-collapse: collapse;
                direction: rtl;
                margin-top: 10px;
            }
            th {
                background-color: #f2f2f2;
                border: 1px solid #ddd;
                padding: 8px;
                text-align: center;
                font-weight: bold;
            }
            td {
                border: 1px solid #ddd;
                padding: 8px;
                text-align: right;
            }
            .address-cell {
                text-align: right;
                padding-right: 15px;
            }
        </style>
        
        <div class="header">
            <h1>
                قائمة المستخدمين
            </h1>
        </div>
        
        <table>
            <thead>
                <tr>
                    <th>الاسم</th>
                    <th>اسم المستخدم</th>
                    <th>الوظيفة</th>
                    <th>رقم البطاقة</th>
                    <th>الهاتف</th>
                    <th>العنوان</th>
                </tr>
            </thead>
            <tbody>';

        foreach ($users as $user) {
            $html .= '
                <tr>
                    <td>'.htmlspecialchars($user->name_ar).'</td>
                    <td>'.htmlspecialchars($user->username).'</td>
                    <td>'.htmlspecialchars($user->getRoleNames()->first()).'</td>
                    <td>'.htmlspecialchars($user->national_id).'</td>
                    <td>'.htmlspecialchars($user->phone ?? '').'</td>
                    <td>
                        '.htmlspecialchars($user->address).'
                    </td>
                </tr>';
        }

        $html .= '
            </tbody>
        </table>';

        return $html;
    }
}