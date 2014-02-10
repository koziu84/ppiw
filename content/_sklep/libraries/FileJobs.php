<?php
/**
* FileJobs - dzialania na plikach
* @author   daniel hydzik <daniel.hydzik@ox.pl> 
* @access   public 
* @version  0.1.7
*/
class FileJobs
{

  var $fileName;
	var $chmod  =	'0777';
	
  /**
  * Przydzielanie nazwy pliku do wlasciwosci
  * @return void
  * @param string $sFileName
  */
  function setFileName( $sFileName ){
    $this->fileName = $sFileName;
  } // end function setFileName
	
  /**
  * Tworzenie pliku
  * @return bool
  * @param string $sFileName
  */
	function addFile( $sFileName = null ){
		
		if( isset( $sFileName ) )
			$this->setFileName( $sFileName );	

		if( is_file( $this->fileName ) )
			return false;
		else{
			@touch( $this->fileName );
			@chmod( $this->fileName, $this->chmod );
			if( is_file( $this->fileName ) )
				return true;
			else
				return false;
		}
	} // end function addFile

  /**
  * Sprawdzanie nazwy pliku
  * @return string
  * @param string $name
  */
	function throwNameOfFile( $name ){
		$ext =	  explode( '.', $name );
    $iCount = count( $ext );
    unset( $ext[$iCount-1] );
    $sName = implode( '.', $ext );
    return $sName;
	} // end function throwNameOfFIle

  /**
  * Sprawdzanie rozszerzenia pliku
  * @return string
  * @param string $name
  */
	function throwExtOfFile( $name ){
		$ext =	explode( '.', $name );
		return	strtolower( $ext[count( $ext )-1] ); 
	} // end function throwExtOfFile

  /**
  * Zwrocenie nazwy i rozszerzenia pliku
  * @return array
  * @param string $sName
  */
  function throwNameExtOfFile( $sName ){
    $aName[0] = $this->throwNameOfFile( $sName );
    $aName[1] = $this->throwExtOfFile( $sName );
    return $aName;
  } // end function throwNameExtOfFile

  /**
  * Zwracanie zawartosci pliku
  * @return string
  * @param string $sFile
  */
  function throwFile( $sFile ){
    if( is_file( $sFile ) ){
      $rFile =    fopen( $sFile, 'r' );
      $sContent = fread( $rFile, filesize( $sFile ) );
      fclose( $rFile );

      return $sContent;
    }
    else
      return null;
  } // end function throwFile

  /**
  * Sprawdzanie czy plik ma odpowiednie rozszerzenia
  * przez przeslanie dopuszczalnych rozszerzen
  * odddzielajac je znacznikiem | np. gif|jpg|png
  * @return int
  * @param string $name
  * @param string $is
  */
	function checkCorrectFile( $name, $is = 'jpg|jpeg' ){
		return preg_match( '/^('.$is.'|)$/', $this->throwExtOfFile( $name ) );
	} // end function checkCorrectFile

  /**
  * Zamienia w nazwie pliku znaki niestandardowe
  * @return 
  * @param 
  */
  function changeFileName( $sFileName ){

    $sFileName = ereg_replace( '\$', '_', $sFileName );
    $sFileName = ereg_replace( '\'', '`', $sFileName );
    $sFileName = ereg_replace( '\"', '`', $sFileName );
    $sFileName = ereg_replace( '\~', '_', $sFileName );
    $sFileName = ereg_replace( '\/', '_', $sFileName );
    $sFileName = ereg_replace( '\\\\', '_', $sFileName );
    $sFileName = ereg_replace( '\?', '_', $sFileName );
    $sFileName = ereg_replace( '#', '_', $sFileName );
    $sFileName = ereg_replace( '%', '_', $sFileName );
    $sFileName = ereg_replace( '\+', '_', $sFileName );

    $sFileName = changePolishToNotPolish( $sFileName );

    return $sFileName;
  } // end function changeFileName

  /**
  * Sprawdza czy plik taki nie istnieje jesli tak to zmienia nazwe i zwraca taka ktora nie istnieje
  * @return string
  * @param string $sFileOutName
  * @param string $sOutDir
  * @param string $sExt
  */
  function checkIsFile( $sFileOutName, $sOutDir = '', $sExt = null ){
    
    $sFileName = $sFileOutName;

    for( $i = 1; is_file( $sOutDir.$sFileOutName ); $i++ )
      $sFileOutName = basename( $sFileName, '.'.$sExt ).'['.$i.'].'.$sExt;

    return $sFileOutName;
  } // end function checkIsFile

  /**
  * Wgrywa plik na serwer
  * @return string
  * @param array  $aFiles
  * @param string $sOutDir
  * @param mixed  $sFileOutName
  */
  function uploadFile( $aFiles, $sOutDir = null, $sFileOutName = null ){
    $sUpFileSrc =   $aFiles['tmp_name'];

    $sUpFileName =  $this->changeFileName( $aFiles['name'] );
    $sExtFile =     $this->throwExtOfFile( $aFiles['name'] );

    if( !isset( $sFileOutName ) )
      $sFileOutName = $sUpFileName;

    $sFileOutName = $this->checkIsFile( $sFileOutName, $sOutDir, $sExtFile );

    if( move_uploaded_file( $sUpFileSrc, $sOutDir.$sFileOutName ) ){
      chmod( $sOutDir.$sFileOutName, 0777 );
      return $sFileOutName;
    }
    else
      return null; 
  } // end function uploadFile

};
?>