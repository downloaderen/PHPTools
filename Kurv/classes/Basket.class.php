<?php
/**
 * Dette er vores indkøbskurv
 *
 */
class Basket
{
	public $sessionName = 'kurv';
	// En privat property
	private $_kurv = array();
	
	// Vores constructor
	public function Basket()
	{
		if(isset($_SESSION[$this->sessionName]))
		{
			if(is_array($_SESSION[$this->sessionName]))
			{
				$this->TagKurv();
			} else {
				$this->GemKurv();
			}
		} else {
			$this->GemKurv();
		}
	}

	private function TagKurv()
	{
		$this->_kurv = $_SESSION[$this->sessionName];
	}

	private function GemKurv()
	{
		$_SESSION[$this->sessionName] = $this->_kurv;
	}

	public function PutIKurv( $id, $antal, $pris, $navn )
	{

		foreach( $this->_kurv as $produktId => $indhold )
		{
			if ( $produktId == $id ) {
				$this->RetVare($id,$antal);
				return;
			}
		}

		$this->_kurv[$id] = array();
		$this->_kurv[$id]["antal"] = $antal;
		$this->_kurv[$id]["navn"] = $navn;
		$this->_kurv[$id]["pris"] = $pris;
		$this->GemKurv();
	}

	public function VisKurv()
	{
		return $this->_kurv;
	}

	public function RetVare( $id, $antal )
	{
		$this->_kurv[$id]["antal"] += $antal ;
		$this->GemKurv();
	}
	public function MinusVare( $id, $antal )
	{
		if($this->_kurv[$id]["antal"] == 1){
			$this->SletVare($id);
			$this->GemKurv();
		} else {
			$this->_kurv[$id]["antal"] -= $antal;
			$this->GemKurv();
		}
	}

	public function SletVare( $id )
	{
		unset($this->_kurv[$id]);
		$this->GemKurv();
	}

	public function Afslut()
	{
		unset($_SESSION[$this->sessionName]);
		$_SESSION[$this->sessionName] = '';
	}
}
?>


