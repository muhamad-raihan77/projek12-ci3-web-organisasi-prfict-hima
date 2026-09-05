<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// Require composer autoloader if available
if (file_exists(FCPATH . 'vendor/autoload.php')) {
    require_once FCPATH . 'vendor/autoload.php';
}

use Dompdf\Dompdf;
use Dompdf\Options;

class Pdf_generator {

    public function generate($html, $filename = 'document.pdf', $stream = TRUE, $paper = 'A4', $orientation = 'portrait') {
        $options = new Options();
        $options->set('isRemoteEnabled', true);
        $options->set('isHtml5ParserEnabled', true);
        $options->set('chroot', FCPATH);
        
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper($paper, $orientation);
        $dompdf->render();

        if ($stream) {
            // Clean output buffer to ensure uncorrupted PDF stream
            if (ob_get_level()) {
                ob_end_clean();
            }
            $dompdf->stream($filename, ["Attachment" => true]);
            exit(0);
        } else {
            return $dompdf->output();
        }
    }
}
