<?php
/**
* FlatFiles - operowanie na plikach jako bazach danych
* @author   daniel hydzik <daniel.hydzik@ox.pl> 
* @access   public 
* @version  0.2.1
* @require  FileJobs
* @require  Trash
*/
class FlatFiles extends FileJobs
{
	var $row;
	var $txt;
  var $string;
	var $seperator  =	'$';
	var $break      = "\n";
  var $rFile;
  var $mData;

  /**
  * Przydzielanie array'a do wlasciwosci
  * @return void
  * @param array $aData
  */
  function setRow( $aData ){
    $this->row = $aData;
  } // end function setRow

  /**
  * Przydzielanie wartosci pomocniczej
  * @return void
  * @param mixed  $mData
  */
  function setData( $mData ){
    $this->mData = $mData;
  } // end function setData

  /**
  * Przydzielanie stringa do wlasciwosci
  * @return void
  * @param string $sText
  */
  function setString( $sText ){
    $this->string = $sText;
  } // end function setString

	/**
  * Otwarcie pliku
  * @return int
  * @param string $sAtrybut
  */
	function openFile( $sAtrybut ){
		$this->rFile = fopen( $this->fileName, $sAtrybut );
	} // end function openFile
	
	/**
  * Zamkniecie pliku
  * @return void
  */
	function closeFile( ){
		fclose( $this->rFile );
	} // end function closeFile

  /**
  * Dodawanie danych do pliku
  * @return null
  * @param string $sFile
  * @param string $sOption
  * @param string $sAttribute
  */
  function addToFile( $sFile = null, $sOption = 'end', $sAttribute = 'a' ){
		if( isset( $sFile ) )
			$this->setFileName( $sFile );	
		if( isset( $this->row ) && is_array( $this->row ) )
			$this->txt = implode( $this->seperator, $this->row ).$this->seperator;
		else 
			$this->txt = $this->string;
    if( ereg( 'sort', $sOption ) ){
      $this->saveData( $sOption );
    }
    else{
			$this->openFile( $sAttribute );
			$this->addToEnd( );
    }
		$this->closeFile( );
		unset( $this->mData, $this->row, $this->string );
	} // end function addToFile

  /**
  * Dodanie wg posortowanych danych
  * Wymagane zdefiniowanie: $this->mData
  * @return void
  * @param string $sSortFunction
  * @param mixed  $mValue
  * @param int    $iPosition
  */
  function saveData( $sSortFunction = 'sort', $mValue = null, $iPosition = 0 ){

    $aFile = file( $this->fileName );
    $this->openFile( 'w' );

    if( !isset( $this->mData ) || !is_array( $this->mData ) ){
      $iCount= substr_count( $this->txt, '$' );
      for( $i = 0; $i < $iCount; $i++ ){
        $this->mData[] = $i;
      } // end for
    }

    if( !isset( $mValue ) )
      $aFile[] = $this->txt;

    $iCount = count( $aFile );
    $iCount2= count( $this->mData );

    if( $this->throwExtOfFile( $this->fileName ) == 'php' ){
      $sSaveFirst = rtrim( $aFile[0] );
      $iStart = 1;
    }
    else
      $iStart = 0;

    for( $i = 0; $i < $iCount2; $i++ ){
      $aDataAfter[] = array_search( $i, $this->mData );
    } // end for

    $i3 = 0;
    for( $i = $iStart; $i < $iCount; $i++ ){
      $aData = explode( $this->seperator, rtrim( $aFile[$i] ) );

      if( isset( $mValue ) && $aData[$iPosition] == $mValue ){
        $aData = explode( $this->seperator, rtrim( $this->txt ) );
      }
      for( $i2 = 0; $i2 < $iCount2; $i2++ ){
        $aSave[$i3][$i2] = $aData[$this->mData[$i2]];
      } // end for
      $i3++;
    } // end for

    if( isset( $sSortFunction ) )    
      $sSortFunction( $aSave );

    for( $i = 0; $i < $iCount; $i++ ){
      $sSave = null;

      if( $i == 0 && isset( $sSaveFirst ) ){
        $sSave .= $sSaveFirst.$this->break;
        $iCount--;
      }

      for( $i2 = 0; $i2 < $iCount2; $i2++ ){
        $sSave .= $aSave[$i][$aDataAfter[$i2]].$this->seperator;
      } // end for
      
      fwrite( $this->rFile, $sSave.$this->break );
    } // end for

  } // end function saveSorted

  /**
  * Dodawanie danych do konca pliku
  * @return bool
  */
	function addToEnd( ){
    fwrite( $this->rFile, $this->txt.$this->break );
	} // end function addToEnd

  /**
  * Zwracanie ostatniego id z pliku
  * @return int
  * @param string $sFile
  * @param int    $iPosition
  * @param int    $iExpLimit
  */
  function throwLastId( $sFile, $iPosition = 1, $iExpLimit = 20 ){
    $this->setFileName( $sFile );

    if( is_file( $this->fileName ) ){
      $aFile  = file( $this->fileName );
      $iCount = count( $aFile );
      $iMax   = 0;
      if( $this->throwExtOfFile( $this->fileName ) == 'php' )
        $iStart = 1;
      else
        $iStart = 0;
      for( $i = $iStart; $i < $iCount; $i++ ){
        $aExp = explode( $this->seperator, $aFile[$i] );
        if( $aExp[$iPosition] > $iMax )
          $iMax = $aExp[$iPosition];
      } // end for
      return $iMax;
    }
    else
      return null;
  } // end function throwLastId


  /**
  * Zwracanie zawartosci pliku w postaci array'a
  * @return array
  * @param string $sFile
  * @param string $sSort
  * @param int    $iEol
  */
  function throwFileArray( $sFile = null, $sSort = null, $iEol = 20000 ){
    return $this->throwFileArrayClause( $sFile, $sSort, null, null, $iEol );
  } // end function throwFileArray

  /**
  * Zwracanie zawartosci pliku w postaci array'a oraz podzial na strony
  * @return array
  * @param string $sFile
  * @param string $sSort
  * @param int    $iPage
  * @param int    $iMax
  * @param int    $iExpLimit
  */
  function throwFileArrayPages( $sFile = null, $sSort = null, $iPage = null, $iMax = 20, $iExpLimit = 20 ){
    return $this->throwFileArrayClausePages( $sFile, $sSort, $iPage, $iMax, null, null, $iExpLimit );
  } // end function throwFileArrayPages

  /**
  * Zwracanie zawartosci pliku w postaci array'a po spelnieniu warunku zwracanego przez funkcje
  * @return array
  * @param string $sFile
  * @param string $sSort
  * @param string $sFunction
  * @param mixed  $mFunctionParam
  * @param int    $iEol
  */
  function throwFileArrayFunction( $sFile = null, $sSort = null, $sFunction, $mFunctionParam = null, $iEol = 20000 ){
    if( isset( $sFile ) )
			$this->setFileName( $sFile );
    $this->openFile( 'r' );
    if( $this->throwExtOfFile( $this->fileName ) == 'php' )
      $iStart = 1;
    else
      $iStart = 0;
    $i = 0;
    while( ( $aFile = fgetcsv( $this->rFile, $iEol, $this->seperator ) ) !== FALSE ){
      if( $i >= $iStart )
        $bReturnFunc = $sFunction( $aFile, $mFunctionParam );
      if( isset( $bReturnFunc ) ){
        $aData[] = $aFile;
      }
      $i++;
    } // end while
    $this->closeFile( );
    if( isset( $aData ) ){
      if( isset( $sSort ) )
        $sSort( $aData );
      return $aData;
    }
    else
      return null;
  } // end function throwFileArrayFunction

  /**
  * Zwracanie zawartosci pliku w postaci array'a po spelnieniu warunku zwracanego przez funkcje
  * @return array
  * @param string $sFile
  * @param string $sSort
  * @param int    $iPage
  * @param int    $iMax
  * @param string $sFunction
  * @param mixed  $mFunctionParam
  * @param int    $iExpLimit
  */
  function throwFileArrayFunctionPages( $sFile = null, $sSort = null, $iPage = null, $iMax = 20, $sFunction, $mFunctionParam = null, $iExpLimit = 20 ){
    if( isset( $sFile ) )
			$this->setFileName( $sFile );
    $aFile = file( $this->fileName );
    $iCount     = count( $aFile );
    $iFindPage  = 0;
    $iFindAll   = 0;
    if( isset( $sSort ) )
      $sSort( $aFile );
    if( $this->throwExtOfFile( $this->fileName ) == 'php' )
      $iStart = 1;
    else
      $iStart = 0;
    for( $i = $iStart; $i < $iCount; $i++ ){
      $aExp = explode( '$', $aFile[$i], $iExpLimit );
      $bReturnFunc = $sFunction( $aExp, $mFunctionParam );
      if( isset( $bReturnFunc ) ){
        $iFindPage++;
        $iFindAll++;
        
        if( $iFindPage == 1 )
          $aPageStart[] = $i;

        if( isset( $aPageStart[$iPage - 1] ) && !isset( $aPageEnd[$iPage - 1] ) ){
          $aData[] = $aExp;
        }

        if( $iFindPage == $iMax ){
          $aPageEnd[] = $i;
          $iFindPage =  0;
        }
      }
    } // end for
    if( isset( $aData ) ){
      $aData[0]['iFindAll'] = $iFindAll;
      return $aData;
    }
    else
      return null;
  } // end function throwFileArrayFunctionPages

  /**
  * Zwracanie zawartosci pliku w postaci array'a po spelnieniu warunku if oraz podzial na strony
  * @return array
  * @param string $sFile
  * @param string $sSort
  * @param int    $iPage
  * @param int    $iMax
  * @param int    $iVerifyIndex
  * @param int    $mValue
  * @param int    $iExpLimit
  */
  function throwFileArrayClausePages( $sFile = null, $sSort = null, $iPage = null, $iMax = 20, $iVerifyIndex, $mValue, $iExpLimit = 20 ){
    if( isset( $sFile ) )
			$this->setFileName( $sFile );
    $aFile = file( $this->fileName );
    $iCount     = count( $aFile );
    $iFindPage  = 0;
    $iFindAll   = 0;
    if( isset( $sSort ) )
      $sSort( $aFile );
    if( $this->throwExtOfFile( $this->fileName ) == 'php' )
      $iStart = 1;
    else
      $iStart = 0;
    for( $i = $iStart; $i < $iCount; $i++ ){
      $aExp = explode( '$', $aFile[$i], $iExpLimit );
      if( !isset( $mValue ) || $aExp[$iVerifyIndex] == $mValue ){
        $iFindPage++;
        $iFindAll++;
        
        if( $iFindPage == 1 )
          $aPageStart[] = $i;

        if( isset( $aPageStart[$iPage - 1] ) && !isset( $aPageEnd[$iPage - 1] ) ){
          $aData[] = $aExp;
        }

        if( $iFindPage == $iMax ){
          $aPageEnd[] = $i;
          $iFindPage =  0;
        }
      }
    } // end for
    if( isset( $aData ) ){
      $aData[0]['iFindAll'] = $iFindAll;
      return $aData;
    }
    else
      return null;
  } // end function throwFileArrayClausePages

  /**
  * Zwracanie zawartosci pliku w postaci array'a po spelnieniu warunku if
  * @return array
  * @param string $sFile
  * @param string $sSort
  * @param int    $iVerifyIndex
  * @param int    $mValue
  * @param int    $iEol
  */
  function throwFileArrayClause( $sFile = null, $sSort = null, $iVerifyIndex, $mValue, $iEol = 20000 ){
    if( isset( $sFile ) )
			$this->setFileName( $sFile );
    $this->openFile( 'r' );
    if( $this->throwExtOfFile( $this->fileName ) == 'php' )
      $iStart = 1;
    else
      $iStart = 0;
    $i = 0;
    while( ( $aFile = fgetcsv( $this->rFile, $iEol, $this->seperator ) ) !== FALSE ){
      if( $i >= $iStart && ( !isset( $mValue ) || $aFile[$iVerifyIndex] == $mValue ) ){
        $aData[] = $aFile;
      }
      $i++;
    } // end while
    $this->closeFile( );
    if( isset( $aData ) ){
      if( isset( $sSort ) )
        $sSort( $aData );
      return $aData;
    }
    else
      return null;
  } // end function throwFileArrayClause

  /**
  * Zwracanie zawartosci pliku w postaci array'a z wybranymi polami.
  * @return array
  * @param string $sFile
  * @param string $sSort
  * @param int    $iIndexFirst - index array'a
  * @param int    $iIndexSecond - index wartosci array'a
  * @param int    $iEol
  */
  function throwFileArraySmall( $sFile = null, $sSort = null, $iIndexFirst = 0, $iIndexSecond = 1, $iEol = 20000 ){
    if( isset( $sFile ) )
			$this->setFileName( $sFile );
    $this->openFile( 'r' );
    if( $this->throwExtOfFile( $this->fileName ) == 'php' )
      $iStart = 1;
    else
      $iStart = 0;
    $i = 0;
    while( ( $aFile = fgetcsv( $this->rFile, $iEol, $this->seperator ) ) !== FALSE ){
      if( $i >= $iStart ){
        $aData[$aFile[$iIndexFirst]] = changeTxt( $aFile[$iIndexSecond] );
      }
      $i++;
    } // end while
    $this->closeFile( );
    if( isset( $aData ) ){
      if( isset( $sSort ) )
        $sSort( $aData );
      return $aData;
    }
    else
      return null; 
  } // end function throwFileArraySmall

  /**
  * Zwracanie danych z pliku
  * @return array
  * @param string $sFile
  * @param mixed  $mValue
  * @param int    $iPosition
  * @param int    $iEol
  */
  function throwData( $sFile = null, $mValue, $iPosition = 0, $iEol = 20000 ){
		if( isset( $sFile ) )
			$this->setFileName( $sFile );	
    $this->openFile( 'r' );
    if( $this->throwExtOfFile( $this->fileName ) == 'php' )
      $iStart = 1;
    else
      $iStart = 0;
    $i = 0;
    while( ( $aFile = fgetcsv( $this->rFile, $iEol, $this->seperator ) ) !== FALSE ){
      if( $i >= $iStart && $aFile[$iPosition] == $mValue ){
        $aReturn = $aFile;
      }
      $i++;
    } // end while
    $this->closeFile( );
    if( isset( $aReturn ) )
      return $aReturn;
    else
      return null; 
  } // end function throwData

  /**
  * Zwracanie danych z pliku w postaci select'a
  * @return string
  * @param string $sFile
  * @param int    $iId
  * @param int    $iVerify - index tablicy do porownania z $iId
  * @param int    $iValue - wartosc wyswietlana w optionie
  * @param int    $iName - nazwa wyswietlana w optionie
  * @param int    $iEol
  */
  function throwFileSelect( $sFile = null, $iId, $iVerify = 0, $iValue = 0, $iName = 1, $iEol = 20000 ){
		if( isset( $sFile ) )
			$this->setFileName( $sFile );	
    $this->openFile( 'r' );
    if( $this->throwExtOfFile( $this->fileName ) == 'php' )
      $iStart = 1;
    else
      $iStart = 0;
    $i        = 0;
    $sOption  = null;
    while( ( $aFile = fgetcsv( $this->rFile, $iEol, $this->seperator ) ) !== FALSE ){
      if( $i >= $iStart ){
        if( isset( $iId ) && $aFile[$iVerify] == $iId )
          $sSelected = 'selected="selected"';
        else
          $sSelected = null;
  
        $sOption .= '<option value="'.$aFile[$iValue].'" '.$sSelected.' >'.$aFile[$iName].'</option>';
      }
      $i++;
    } // end while
    $this->closeFile( );
    return $sOption;  
  } // end function throwDataSelect

  /**
  * Usuwanie danych z pliku
  * @return bool
  * @param string $sFile
  * @param mixed  $mValue
  * @param int    $iPosition
  */
  function deleteInFile( $sFile = null, $mValue, $iPosition = 0 ){
		if( isset( $sFile ) )
			$this->setFileName( $sFile );	
    if( $this->throwExtOfFile( $this->fileName ) == 'php' )
      $iStart = 0;
    else
      $iStart = -1;
    $bFound = null;
    $aFile  = file( $this->fileName );
    $iCount = count( $aFile );
    $this->openFile( 'w' );
    for( $i = 0; $i < $iCount; $i++ ){
      if( $i > $iStart ){
        $aExp = explode( '$', $aFile[$i] );
        if( $aExp[$iPosition] == $mValue ){
          $aFile[$i] = null;
          $bFound = true;
        }
      }
      fwrite( $this->rFile, $aFile[$i] );
    } // end for
		$this->closeFile( );		
		return $bFound;
	} // end function deleteInFile

  /**
  * Zmienianie danych w pliku
  * @return null
  * @param string $sFile
  * @param mixed  $mValue
  * @param int    $iPosition
  * @param string $sOption
  */
  function changeInFile( $sFile = null, $mValue, $iPosition = 0, $sOption = null ){
    if( isset( $sFile ) )
			$this->setFileName( $sFile );	
		if( isset( $this->row ) && is_array( $this->row ) )
			$this->txt = implode( $this->seperator, $this->row ).$this->seperator;
		else 
			$this->txt = $this->string;
    if( ereg( 'sort', $sOption ) )
      $this->saveData( $sOption, $mValue, $iPosition );
    else
      $this->saveData( null, $mValue, $iPosition );
		$this->closeFile( );
    unset( $this->mData, $this->row, $this->string );
	} // end function changeInFile
};
?>