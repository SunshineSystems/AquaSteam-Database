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
		
		//Page header, only to be displayed on first page, if our html tables extend to the next page, tcpdf will throw errors
		//if the header is trying to be displayed on the next page.
	    public function Header() {
			if($this->page == 1){
				// Logo
	        	$image_file = K_PATH_IMAGES.'logo.png';
	        	$this->Image($image_file, 10, 10, 60, '', 'PNG', '', 'M', false, 300, '', false, false, 0, false, false, false);
			}
			else {
				return;
			}
	    }
	
	    // Page footer
	    public function Footer() {
	        // Position at 15 mm from bottom
	        $this->SetY(-15);
	        // Set font
	        $this->SetFont('helvetica', 'I', 8);
	        // footer content... sorry for the mess
	        $date = date("m/d/Y");
	        $this->Cell(0, 10, 'Printed On: '.$date.'                                                                      AquaPro 2.0                                                                                Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
	    }
	}

?>