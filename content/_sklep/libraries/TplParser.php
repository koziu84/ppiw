<?php
/**
* TplParser - parser plikow zawierajacych kod HTML i PHP
* @author daniel hydzik <daniel.hydzik@ox.pl>
* @access public
* @version 1.1.7
* @date 2005-09-14 08:19:06
*/
class TplParser
{

	var $content;
	var $TplFile;
	var $block;
	var $startBlock;
	var $endBlock;
  var $endBlockLine;
  var $fileContent;	
  var $blockContent;
  var $cache;
  var $iso;
  var $directory;

  /**
  * Konstruktor
  */
	function TplParser( ){
		$this->content 		  = ' ';
		$this->TplFile 		  = '';
		$this->block			  = '';
		$this->startBlock   = '<!-- BEGIN ';
		$this->endBlock 	  = '<!-- END ';
    $this->endBlockLine = ' -->';
    $this->cache        = true;
    $this->iso          = true;
	} // end function TplParser
	
  /**
  * Wyswietlenie calego sparsowanego pliku
  * @return void
  * @param string $sFile - plik *.tpl
  * @param bool   $bCache
  * @param bool   $bIso
  */
	function dHtml( $sFile, $bCache = true, $bIso = true ){
		$this->setFile( $this->directory.$sFile );
    $this->cache =    $bCache;
    $this->iso =      $bIso;

		$this->display( );
    echo $this->content;
    unset( $this->content );
		flush( );
	} // end function dHtml

  /**
  * Zwrocenie calego sparsowanego pliku
  * @return string
  * @param string $sFile - plik *.tpl
  * @param bool   $bCache
  * @param bool   $bIso
  */
	function tHtml( $sFile, $bCache = true, $bIso = true ){
		$this->setFile( $this->directory.$sFile );
    $this->cache =    $bCache;
    $this->iso =      $bIso;

		$this->display( );
		return $this->content;
	} // end function tHtml

  /**
  * Wyswietlenie sparsowanego bloku w pliku
  * @return void
  * @param string $sFile - plik *.tpl
  * @param string $sBlock
  * @param bool   $bCache
  * @param bool   $bIso
  */
	function dbHtml( $sFile, $sBlock, $bCache = true, $bIso = true ){
		$this->setFile( $this->directory.$sFile );
		$this->setBlock( $sBlock );

    $this->cache =    $bCache;
    $this->iso =      $bIso;

		$this->display( true );
    echo $this->content;
    unset( $this->content );
		flush( );
	} // end function dbHtml
	
  /**
  * Zwrocenie sparsowanego bloku w pliku
  * @return string
  * @param string $sFile - plik *.tpl
  * @param string $block
  * @param bool   $cache
  * @param bool   $iso
  */
	function tbHtml( $sFile, $sBlock, $bCache = true, $bIso = true ){
		$this->setFile( $this->directory.$sFile );
		$this->setBlock( $sBlock );

    $this->cache =    $bCache;
    $this->iso =      $bIso;

		$this->display( true );
		return $this->content;
	} // end function tbHtml

  /**
  * Wykonanie czynnosci na kodzie HTML
  * @return void
  * @param bool $bBlock [optional]
  */
	function display( $bBlock = null ){
		if( $this->checkFile( ) ){
			if( isset( $bBlock ) )
				$this->blockParse( );
			else
				$this->allParse( );
			
			$this->changeTxt( );
		}
	} // end function display
	
	/**
	* Zmiana polskich liter na znaki ISO-8859-2
	* @return void
	*/
	function changeTxt( ){
    if( $this->iso == true ){
      $aStr[] = '/œ/';
      $aStr[] = '/¹/';
      $aStr[] = '/Œ/';
      $aStr[] = '/Ÿ/';
      $aStr[] = '/¥/';
      $aStr[] = '//';

      $aRep[] = '¶';
      $aRep[] = '±';
      $aRep[] = '¦';
      $aRep[] = '¼';
      $aRep[] = '¡';
      $aRep[] = '¬';
      $this->content = preg_replace( $aStr, $aRep, $this->content );
    }
	} // end function changeTxt
	
	/**
  * Sprawdzenie istnienia pliku
  * @return boolean
  */
	function checkFile( ){
		if( is_file( $this->TplFile ) ){
	  	return true;
	  }
		else {
      $this->content = null;
			echo 'No template file: <i>'.$this->TplFile.'</i><br />';
			return false;
		}
	} // end function checkFile
	
  /**
  * Parsowanie zawartosci pliku
  * @return boolean
  */
	function parse( ){

		if( !isset( $poz ) )
      $poz[1][1] = 0;
    
		while( strpos( $this->content, '$', $poz[1][1] ) )  {
			$poz[1][1] = strpos( $this->content, '$', $poz[1][1] ) + 1;

			preg_match( '/\$[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\[\]x7f-\xff]*/', $this->content, $wyniki );

			if( ereg( '\]', $wyniki[0] ) ){
        if( ereg( '\[', $wyniki[0] ) ){
  				$poz[1][2] = $poz[1][1] + strpos( $wyniki[0], ']' );
          $bArray = true;
        }
        else{
          $poz[1][2] = $poz[1][1] + strpos( $wyniki[0], ']' ) - 1;
          $bArray = null;
        }
      }
			else{
				$poz[1][2] = $poz[1][1] + strlen( $wyniki[0] ) - 1;
        $bArray = null;
      }

			$TplVar = substr( $this->content, $poz[1][1], $poz[1][2] - $poz[1][1] );

			if( isset( $bArray ) ){
				list($var,) = explode( '[', $TplVar );
        if( isset( $GLOBALS[$var] ) ){
  				global $$var;
          $poz[2][1]= strpos( $TplVar, '[' )+1;
          $poz[2][2]= strpos( $TplVar, ']' );
          $key = substr( $TplVar, $poz[2][1], $poz[2][2]-$poz[2][1] );
          
          if( isset( ${$var}[$key] ) )
            $tekst = ${$var}[$key];
          else
            $tekst = null;
        }
        else{
          $tekst = null;
        }
			} 
			else {
				global $$TplVar;
  		  $tekst = $$TplVar;
			}
			$this->content = substr( $this->content, 0, $poz[1][1] - 1 ) . $tekst .  substr( $this->content, $poz[1][2] );
		} // end while
		
		$this->content = substr( $this->content, 0 );
		return true;
		
	} // end function parse
	
  /**
  * Pobranie wszystkich danych z pliku
  * @return void
  */
	function allParse( ){
    if( isset( $this->fileContent[$this->TplFile] ) ){
      $this->content = $this->fileContent[$this->TplFile];
    }
    else{
      $this->content = $this->getContent( );
    }
		$this->parse( );
	} // end function allParse
	
  /**
  * Pobranie wybranych danych z pliku
  * i parsowanie
  * @return boolean
  */
	function blockParse( ){
   
    if( isset( $this->blockContent[$this->TplFile][$this->block] ) ){
      $this->content = $this->blockContent[$this->TplFile][$this->block];
    }
    else{
      $this->content = $this->getFileBlock( );
      if( isset( $this->content ) ){
        if( $this->cache == true ){
          $this->blockContent[$this->TplFile][$this->block] = $this->content;
        }
      }
    }
    $this->parse( );
	} // end function blockParse

  /**
  * Otwieranie pliku i jego zawartosci 
  * lub pobieranie ze zmiennej w przypadku cashe'owania
  * @return array
  * @param bool $bBlock
  */
  function getContent( $bBlock = null ){
    if( isset( $this->fileContent[$this->TplFile] ) ){
      $mReturn = $this->fileContent[$this->TplFile];
    }
    else{
      if( isset( $bBlock ) ){
        $mReturn = $this->getFile( $this->TplFile );
      }
      else{
        $mReturn = $this->getFile( $this->TplFile );
      }

      if( $this->cache == true )
        $this->fileContent[$this->TplFile] = $mReturn;
    }
    return $mReturn;
  } // end function getContent

  /**
  * Zwracanie zawartosci pliku do jednej zmiennej
  * metoda moze byc uzywana z zewnatrz
  * @return string
  * @param string $sFile
  */
  function getFile( $sFile ){
    $rFile =  fopen( $sFile, 'r' );
    $iSize =  filesize( $sFile );
    if( $iSize > 0 )
      $sContent = fread( $rFile, $iSize );
    else
      $sContent = null;
    fclose( $rFile );
    return ' '.$sContent;
  } // end function getFile

  /**
  * Pobieranie czesc (bloku) z pliku
  * @return string
  * @param string $sFile [optional]
  * @param string $sBlock [optional]
  */
  function getFileBlock( $sFile = null, $sBlock = null ){
    if( isset( $sFile ) && isset( $sBlock ) ){
      $this->setFile( $sFile );
      $this->setBlock( $sBlock );
    }

    $sFile =          $this->getContent( true );

    $iStart = strpos( $sFile, $this->startBlock.$this->block.$this->endBlockLine );
    $iEnd =   strpos( $sFile, $this->endBlock.$this->block.$this->endBlockLine );

    if( is_int( $iStart ) && is_int( $iEnd ) ){
      $iStart += strlen( $this->startBlock.$this->block.$this->endBlockLine );
      return ' '.substr( $sFile, $iStart, $iEnd - $iStart );
    }
    else {
      echo 'No block: <i>'.$this->block.'</i> in file: '.$this->TplFile.' <br />';
      return null;
    }
  } // end function getFileBlock

  /**
  * Zwracanie zawartosci pliku do array'a
  * metoda moze byc uzywana z zewnatrz
  * @return array
  * @param string $sFile
  */
  function getFileArray( $sFile ){
    return file( $sFile );
  } // end function getFileArray

  /**
  * Zwracanie aktualnego katalogu
  * @return string
  */
  function getDir( ){
    return $this->directory;
  } // end function getDir

  /**
  * Definiowanie katalogu
  * @return void
  * @param string $sDir
  */
  function setDir( $sDir ){
    $this->directory = $sDir;
  } // end function setDir

  /**
  * Definiowanie pliku
  * @return void
  * @param string $sFile
  */
  function setFile( $sFile ){
    $this->TplFile = $sFile;
  } // end function setFile

  /**
  * Definiowanie bloku
  * @return void
  * @param string $sBlock
  */
  function setBlock( $sBlock ){
    $this->block = $sBlock;
  } // end function setBlock

  /**
  * Odparsowanie kodu HTML
  * @return string
  * @param string $txt - kod HTML
  */
  function unparseTxt( $txt ){
    $this->content = $txt;
    while( strpos( $this->content, '$', $poz[1][1] ) )  {
      $poz[1][1] = strpos( $this->content, '$', $poz[1][1] ) + 1;

      preg_match( '/\$[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\[\]x7f-\xff]*/', $this->content, $wyniki );

      if( ereg( ']', $wyniki[0] ) ) 
        $poz[1][2] = $poz[1][1] + strpos( $wyniki[0], ']' ); 
      else 
        $poz[1][2] = $poz[1][1] + strlen( $wyniki[0] ) - 1;

      $TplVar =         substr( $this->content, $poz[1][1], $poz[1][2] - $poz[1][1] );
      $this->content =  substr( $this->content, 0, $poz[1][1] - 1 ) .'{'. $TplVar .'}'. substr( $this->content, $poz[1][2] );
    } // end while
    $this->content = substr( $this->content, 0 );
    return $this->content;
  } // end function unparseTxt

  /**
  * Odparsowanie zmiennych PHP
  * @return string
  * @param string $sContent
  * @param bool   $bParse
  */
  function deparseTxt( $sContent, $bParse = null ){
    $this->content = $sContent;
    $this->content = eregi_replace( 'areatext','textarea', $this->content );
    $this->content = ereg_replace( '{$','$', $this->content );
    $this->content = ereg_replace( '{','$', $this->content ); 
    $this->content = ereg_replace( '}','', $this->content );
    $this->content = stripslashes( $this->content );
    if( isset( $bParse ) )
      $this->parse( );
    return $this->content;
  } // end function deparseTxt

}; // end class TplParser
?>