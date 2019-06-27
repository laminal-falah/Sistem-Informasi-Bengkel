<?php
require_once 'config.php';
require_once 'database.php';
require_once __DIR__ . '/../vendor/setasign/fpdf/fpdf.php';

class PDF extends FPDF
{

    var $angle = 0;
    private $title, $a;

    function __construct($a, $b, $c)
    {
        $this->a = $a;
        parent::__construct($a, $b, $c);
    }

    function setJudul($title)
    {
        $this->title = $title;
    }

    function getJudul()
    {
        return $this->title;
    }

    function Header()
    {
        $this->SetMargins(2, 1, 2);
        $this->SetFont('Arial', 'B', 11);
        $this->Image(BASE_URL . '/assets/img/logosma.png', 1, 1, 2, 2);
        if ($this->a == "P") {
            $this->SetXY(4.2, 1);
            $this->MultiCell(10, 0.5, $this->getJudul(), 0, 'C');
            $this->SetXY(15.1, 1);
            $this->MultiCell(5, 0.5, 'SMK Teknologi BISTEK', 0, 'R');
            $this->SetXY(15.1, 1.78);
            $this->MultiCell(5, 0.5, 'Kota Palembang, Sumsel', 0, 'R');
            $this->SetXY(15.1, 2.50);
            $this->MultiCell(5, 0.5, 'Telepon : 081234567890', 0, 'R');
            $this->SetFont('Arial', 'I', 8);
            $this->SetXY(14.1, 3.0);
            $this->MultiCell(6, 0.5, "Di cetak pada : " . date("d-m-Y") . " Jam " . date("H:i:s"), 0, 'R');
        } elseif ($this->a == "L") {
            $this->SetXY(6.5, 1);
            $this->MultiCell(15, 0.5, $this->getJudul(), 0, 'C');
            $this->SetXY(15.1, 1);
            $this->MultiCell(13.7, 0.5, 'SMK Teknologi BISTEK', 0, 'R');
            $this->SetXY(15.1, 1.78);
            $this->MultiCell(13.7, 0.5, 'Kota Palembang, Sumsel', 0, 'R');
            $this->SetXY(15.1, 2.50);
            $this->MultiCell(13.7, 0.5, 'Telepon : 081234567890', 0, 'R');
            $this->SetFont('Arial', 'I', 8);
            $this->SetXY(22.8, 3.0);
            $this->MultiCell(6, 0.5, "Di cetak pada : " . date("d-m-Y") . " Jam " . date("H:i:s"), 0, 'R');
        }
        $this->Line(1, 3.5, $this->GetPageWidth() - 1, 3.5);
        $this->ln(0.5);
    }

    function Footer()
    {
        $this->SetY(-1.5);
        $this->Line(1, $this->GetY(), $this->GetPageWidth() - 1, $this->GetY());
        $this->SetY(-6);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Halaman ke ' . $this->PageNo() . ' dari {nb} halaman', 0, 0, 'C');
    }

    function Cell($w, $h = 0, $txt = '', $border = 0, $ln = 0, $align = '', $fill = false, $link = '')
    {
        $k = $this->k;
        if ($this->y + $h > $this->PageBreakTrigger && !$this->InHeader && !$this->InFooter && $this->AcceptPageBreak()) {
                $x = $this->x;
                $ws = $this->ws;
                if ($ws > 0) {
                        $this->ws = 0;
                        $this->_out('0 Tw');
                    }
                $this->AddPage($this->CurOrientation);
                $this->x = $x;
                if ($ws > 0) {
                        $this->ws = $ws;
                        $this->_out(sprintf('%.3F Tw', $ws * $k));
                    }
            }
        if ($w == 0)
            $w = $this->w - $this->rMargin - $this->x;
        $s = '';
        if ($fill || $border == 1) {
                if ($fill)
                    $op = ($border == 1) ? 'B' : 'f';
                else
                    $op = 'S';
                $s = sprintf('%.2F %.2F %.2F %.2F re %s ', $this->x * $k, ($this->h - $this->y) * $k, $w * $k, -$h * $k, $op);
            }
        if (is_string($border)) {
                $x = $this->x;
                $y = $this->y;
                if (is_int(strpos($border, 'L')))
                    $s .= sprintf('%.2F %.2F m %.2F %.2F l S ', $x * $k, ($this->h - $y) * $k, $x * $k, ($this->h - ($y + $h)) * $k);
                if (is_int(strpos($border, 'T')))
                    $s .= sprintf('%.2F %.2F m %.2F %.2F l S ', $x * $k, ($this->h - $y) * $k, ($x + $w) * $k, ($this->h - $y) * $k);
                if (is_int(strpos($border, 'R')))
                    $s .= sprintf('%.2F %.2F m %.2F %.2F l S ', ($x + $w) * $k, ($this->h - $y) * $k, ($x + $w) * $k, ($this->h - ($y + $h)) * $k);
                if (is_int(strpos($border, 'B')))
                    $s .= sprintf('%.2F %.2F m %.2F %.2F l S ', $x * $k, ($this->h - ($y + $h)) * $k, ($x + $w) * $k, ($this->h - ($y + $h)) * $k);
            }
        if ($txt != '') {
                if ($align == 'R')
                    $dx = $w - $this->cMargin - $this->GetStringWidth($txt);
                elseif ($align == 'C')
                    $dx = ($w - $this->GetStringWidth($txt)) / 2;
                elseif ($align == 'FJ') {
                        //Set word spacing
                        $wmax = ($w - 2 * $this->cMargin);
                        $this->ws = ($wmax - $this->GetStringWidth($txt)) / substr_count($txt, ' ');
                        $this->_out(sprintf('%.3F Tw', $this->ws * $this->k));
                        $dx = $this->cMargin;
                    } else
                    $dx = $this->cMargin;
                $txt = str_replace(')', '\\)', str_replace('(', '\\(', str_replace('\\', '\\\\', $txt)));
                if ($this->ColorFlag)
                    $s .= 'q ' . $this->TextColor . ' ';
                $s .= sprintf('BT %.2F %.2F Td (%s) Tj ET', ($this->x + $dx) * $k, ($this->h - ($this->y + .5 * $h + .3 * $this->FontSize)) * $k, $txt);
                if ($this->underline)
                    $s .= ' ' . $this->_dounderline($this->x + $dx, $this->y + .5 * $h + .3 * $this->FontSize, $txt);
                if ($this->ColorFlag)
                    $s .= ' Q';
                if ($link) {
                        if ($align == 'FJ')
                            $wlink = $wmax;
                        else
                            $wlink = $this->GetStringWidth($txt);
                        $this->Link($this->x + $dx, $this->y + .5 * $h - .5 * $this->FontSize, $wlink, $this->FontSize, $link);
                    }
            }
        if ($s)
            $this->_out($s);
        if ($align == 'FJ') {
                //Remove word spacing
                $this->_out('0 Tw');
                $this->ws = 0;
            }
        $this->lasth = $h;
        if ($ln > 0) {
                $this->y += $h;
                if ($ln == 1)
                    $this->x = $this->lMargin;
            } else
            $this->x += $w;
    }
}

