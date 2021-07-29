<?php
require_once "lib/Session.php";
require_once "classes/Users.php";

require('fpdf/fpdf.php');

Session::init();
Session::CheckSession();

class PDF extends FPDF
{
    public function __construct($orientation = 'P', $unit = 'mm', $size = 'A4')
    {
        parent::__construct('L', $unit, $size);
        $this->SetTitle(time());
    }

// Load data
    function LoadData($allUsers)
    {
        $data = [];
        $i = 0;
        foreach($allUsers as $one_user){
            $i++;
            $user_array = array(
                $i,
                $one_user->name,
                $one_user->username,
                $one_user->email,
                $one_user->mobile,
                $one_user->isActive,
                $one_user->created_at
            );
            array_push($data,  $user_array);
        }
        return $data;
    }

// Simple table
    function BasicTable($header, $data)
    {
        // Header
        foreach($header as $col)
            $this->Cell(40,7,$col,1);
        $this->Ln();
        // Data
        foreach($data as $row)
        {
            foreach($row as $col)
                $this->Cell(40,6,$col,1);
            $this->Ln();
        }
    }
}

if(Session::get('roleid') != 1){
    echo "only admin allowed to export.";
    exit;
}

$users = new Users();
$allUsers = $users->selectAllUserData();

$pdf = new PDF();
// Column headings
$header = array(
'SL',
'Name',
'Username',
'Email address',
'Mobile',
'Status',
'Created'
);
// Data loading
$data = $pdf->LoadData($allUsers);
$pdf->SetFont('Arial','',8);
$pdf->AddPage();
$pdf->BasicTable($header,$data);
$pdf->Output();

