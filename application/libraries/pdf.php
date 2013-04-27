<?php 
	
	require_once dirname(__FILE__) . '/tcpdf/tcpdf.php';
	/* pdf library that extends the tcpdf class, in order to create a custom header/footer to be used
	 * on the printable work orders.
	 */
	class PDF extends TCPDF
	{
	    function __construct()
	    {
	        parent::__construct();
	    }
		
		//Page header
	    public function Header() {
	        // Logo
	        $image_file = K_PATH_IMAGES.'logo.png';
	        $this->Image($image_file, 10, 10, 60, '', 'PNG', '', 'M', false, 300, '', false, false, 0, false, false, false);
	        // Set font
	        $this->SetFont('helvetica', 'B', 20);
	        // Title
	        $date = date("m/d/Y");
	        $this->Cell(10, 15, "               Work Order", 0, false, 'L', 0, '', 0, false, 'M', 'B');
			$this->SetFont('helvetica', 'B', 10);
			$this->Cell(0, 15, "Date: $date", 0, false, 'R', 0, '', 0, false, 'M', 'B');
	    }
	
	    // Page footer
	    public function Footer() {
	        // Position at 15 mm from bottom
	        $this->SetY(-15);
	        // Set font
	        $this->SetFont('helvetica', 'I', 8);
	        // Page number
	        $this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
	    }
	}

?>