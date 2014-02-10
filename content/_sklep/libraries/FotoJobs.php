<?php
/**
* FotoJobs - zmiany fotografii
* @author   zdzislaw zawada <zdzislaw.zawada@ox.pl> 
* @access   public 
* @version  0.0.8
* @require  FileJobs
* @require  Trash
* @date     2005-09-14 08:20:49
*/
class FotoJobs extends FileJobs
{

  var $iThumbX          = 100;

  var $iThumbY          = 100;

  var $iQuality         = 80;

  var $iThumbAdd        = '_m';

  var $sExt             = 'jpg';

  var $iMaxForThumbSize = 2000;

  var $fRatio           = 0.65;

  /**
  * Konstruktor
  * @return void
  * @param  int   $iThumbSize
  */
  function FotoJobs( $iThumbSize = 100 ){
    $this->iThumbX = $iThumbSize;
  } // end function FotoJobs

  /**
  * Ustawia rozmiar miniaturki zdjecia
  * @return void
  * @param  int   $iThumbSize
  */
  function setThumbSize( $iThumbSize = 100 ){
    $this->iThumbX = $iThumbSize;
  } // end function setThumbSize

  /**
  * Ustawia jakosc miniaturki zdjecia
  * @return void
  * @param  int   $iThumbQuality
  */
  function setThumbQuality( $iThumbQuality = 80 ){
    $this->iQuality = $iThumbQuality;
  } // end function setThumbQuality

  /**
  * Ustawia przytostek nazwy dla miniaturki zdjecia
  * @return void
  * @param  int   $iThumbAdd
  */
  function setThumbAdd( $iThumbAdd = '_m' ){
    $this->iThumbAdd = $iThumbAdd;
  } // end function setThumbAdd

  /**
  * Ustawia max rozmiar zdjecia dla ktorego tworza sie miniaturki
  * @return void
  * @param  int   $iMaxForThumbSize
  */
  function setMaxForThumbSize( $iMaxForThumbSize = 2000 ){
    $this->iMaxForThumbSize = $iMaxForThumbSize;
  } // end function setMaxForThumbSize

  /**
  * Ustawia proporcje obrazka
  * @return void
  * @param  int   $fRatio
  */
  function setRatio( $fRatio = 0.65 ){
    $this->fRatio = $fRatio;
  } // end function setRatio

  /**
  * Obsluguje upload lub kopiowanie plikow i tworzenie z nich miniaturek
  * @return array
  * @param string $sDestDir - katalog docelowy
  * @param mixed  $mImgSrc - odpowiada array $_FILES jesli upload lub sciezce do pliku jesli copy
  * @param string $sImgOutput - proponowana nazwa pliku wyjsciowego
  * @param mixed  $sOption - upload lub copy
  */
  function copyAndCreateThumb( $sDestDir, $mImgSrc, $sImgOutput, $sOption = null ){

    // zapamietanie wielkosci dla miniaturek
    $iOldSize = $this->iThumbX;

    if( !is_dir( $sDestDir ) )
      return null;

    $sImgOutput = $this->throwNameOfFile( $sImgOutput );

    $sImgOutput = $this->changeFileName( $sImgOutput );

    if( $sOption == 'upload' ){
      if( is_uploaded_file( $mImgSrc['tmp_name'] ) && is_file( $mImgSrc['tmp_name'] ) && filesize( $mImgSrc['tmp_name'] ) > 0 && $this->checkCorrectFile( $mImgSrc['name'], 'jpg|jpeg|gif|png' ) == 1 ){
        $this->sExt = $this->throwExtOfFile( $mImgSrc['name'] );
        $aNewFiles['bFile'] = $this->uploadFile( $mImgSrc, $sDestDir, $sImgOutput.'.'.$this->sExt );
      }
      else
        return null;
    }
    elseif( $sOption == 'copy' ){
      if( is_file( $mImgSrc ) && filesize( $mImgSrc ) > 0 && $this->checkCorrectFile( $mImgSrc, 'jpg|jpeg|gif|png' ) == 1 ){
        $this->sExt = $this->throwExtOfFile( $mImgSrc );
        $aNewFiles['bFile'] = $this->checkIsFile( $sImgOutput.'.'.$this->sExt, $sDestDir, $this->sExt );
        if( !copy( $mImgSrc, $sDestDir.$aNewFiles['bFile'] ) )
          return null;
      }
      else
        return null;
    }
    $sImgPatch = $sDestDir.$aNewFiles['bFile'];

    $aNewFiles['bName'] = basename( $aNewFiles['bFile'], '.'.$this->sExt );
    $aNewFiles['sFile'] = $aNewFiles['bName'] . $this->iThumbAdd . '.' . $this->sExt;
    $aImgSize = $this->throwImgSize( $sImgPatch );

    if( defined( 'MAX_DIMENSION_OF_IMAGE' ) && ( $aImgSize['width'] > MAX_DIMENSION_OF_IMAGE || $aImgSize ['height'] > MAX_DIMENSION_OF_IMAGE ) ){
      if( $aImgSize['width'] < $this->iMaxForThumbSize && $aImgSize ['height'] < $this->iMaxForThumbSize ){
        $iOldAdd  = $this->iThumbAdd;
        $this->setThumbSize( MAX_DIMENSION_OF_IMAGE );
        $this->setThumbAdd( '' );
        $aNewFiles['bFile'] = $this->createThumb( $sImgPatch, $sDestDir, $aNewFiles['bFile'] );
        $this->setThumbSize( $iOldSize );
        $this->setThumbAdd( $iOldAdd );
      }
      else
        return null;
    }
  
    if( $aImgSize['width'] >= $this->iThumbX || $aImgSize['height'] >= $this->iThumbX ){
      if( $aImgSize['width'] < $this->iMaxForThumbSize && $aImgSize ['height'] < $this->iMaxForThumbSize )
        $aNewFiles['sFile'] = $this->createThumb( $sImgPatch, $sDestDir );
      else
        return null;
    }
    else
      copy( $sImgPatch, $sDestDir.$aNewFiles['sFile'] );

    $aNewFiles['bWidth']    = $aImgSize['width'];
    $aNewFiles['bHeight']   = $aImgSize['height'];
    $aNewFiles['sWidth']    = $this->iThumbX;
    $aNewFiles['sHeight']   = $this->iThumbY;
    $aNewFiles['sName']     = basename( $aNewFiles['sFile'], '.'.$this->sExt );
    $aNewFiles['ext']       = $this->sExt;

    $this->iThumbY = 100;
    $this->setThumbSize( $iOldSize );

    return $aNewFiles;
  } // end function copyAndCreateThumb

  /**
  * Czysci wszystkie zmienne klasy
  * @return void
  */
  function clearAll( ){
    $this->iThumbX = 100;
    $this->iThumbY = 100;
  } // end function clearAll

  /**
  * Zwraca wielkosc obrazka w px
  * @return array/int
  * @param string $imgSrc
  * @param mixed  $sOption
  */
  function throwImgSize( $imgSrc, $sOption = null ){
    $aImg = getImageSize( $imgSrc );

    $aImgSize['width'] = $aImg[0];
    $aImgSize['height'] = $aImg[1];

    if( $sOption == 'width' || $sOption == 'height' )
      return $aImgSize[$sOption];
    else
      return $aImgSize;
  } // end function throwImgSize

  /**
  * Zwraca wielkosc szerokosc obrazka w px
  * @return int
  * @param  string  $imgSrc
  */
  function throwImgWidth( $imgSrc ){
    return $this->throwImgSize( $imgSrc, 'width' );
  } // end function throwImgWidth
  
  /**
  * Zwraca wysokosc obrazka w px
  * @return int
  * @param  string  $imgSrc
  */
  function throwImgHeight( $imgSrc ){
    return $this->throwImgSize( $imgSrc, 'height' );
  } // end function throwImgHeight

  /**
  * Funckcja tworzaca miniaturki zdjec
  * @return int
  * @param string $sImgSource   - plik zrodlowy z ktorego tworzona jest miniaturka
  * @param string $sImgDestDir  - katalog docelowy dla miniaturki
  * @param string $sImgOutput   - nazwa zdjecia po zmniejszeniu (domyslnie stara nazwa plus _m)
  * @param mixed  $sOption - b/d
  */ 
  function createThumb( $sImgSource, $sImgDestDir, $sImgOutput = false, $iQuality = null, $sOption = null ) { 
    
    if( !is_dir( $sImgDestDir ) && $this->checkCorrectFile( $sImgSource, 'jpg|jpeg|gif|png' ) == 0 )
      return null;

    if( !is_numeric( $iQuality ) )
      $iQuality = $this->iQuality;

    $sImgExt = $this->throwExtOfFile( $sImgSource );

    if( $sImgOutput == false )
      $sImgOutput = basename( $sImgSource, '.'.$sImgExt ) . $this->iThumbAdd . '.' . $sImgExt;

    $sImgOutput = $this->changeFileName( $sImgOutput );

    $sImgBackup = $sImgDestDir.$sImgOutput . "_backup.jpg";
    copy( $sImgSource, $sImgBackup );
    $aImgProperties = GetImageSize( $sImgBackup );

    if ( !$aImgProperties[2] == 2 ) {
      return null;
    }
    else {
      switch( $sImgExt ) {
        case 'jpg':
          $mImgCreate = ImageCreateFromJPEG( $sImgBackup );
            break;
        case 'jpeg':
          $mImgCreate = ImageCreateFromJPEG( $sImgBackup );
            break;
        case 'png':
          $mImgCreate = ImageCreateFromPNG( $sImgBackup );
            break;
        case 'gif':
          $mImgCreate = ImageCreateFromGIF( $sImgBackup );
      }

      $iImgCreateX = ImageSX( $mImgCreate );
      $iImgCreateY = ImageSY( $mImgCreate );

      $iScaleX = $this->iThumbX / ( $iImgCreateX );
      $this->iThumbY = $iImgCreateY * $iScaleX;

      $iRatio  = $this->iThumbX / $this->iThumbY;

      if( $iRatio < $this->fRatio ) {
        $this->iThumbY  = $this->iThumbX;
        $iScaleY        = $this->iThumbY / ( $iImgCreateY );
        $this->iThumbX  = $iImgCreateX * $iScaleY;
      }

      $this->iThumbX  = ( int )( $this->iThumbX );
      $this->iThumbY  = ( int )( $this->iThumbY );
      $mImgDest       = imagecreatetruecolor( $this->iThumbX, $this->iThumbY );
      unlink( $sImgBackup );

      if( function_exists( 'imagecopyresampled' ) )
        $sCreateFunction = 'imagecopyresampled';
      else
        $sCreateFunction = 'imagecopyresized';

      if( !$sCreateFunction( $mImgDest, $mImgCreate, 0, 0, 0, 0, $this->iThumbX + 1, $this->iThumbY + 1, $iImgCreateX, $iImgCreateY ) ) {
        imagedestroy( $mImgCreate );
        imagedestroy( $mImgDest );
        return null;
      }
      else {
        imagedestroy( $mImgCreate );
        switch( $sImgExt ) {
          case 'jpg':
            $Image = ImageJPEG( $mImgDest, $sImgDestDir.$sImgOutput, $iQuality );
            break;
          case 'jpeg':
            $Image = ImageJPEG( $mImgDest, $sImgDestDir.$sImgOutput, $iQuality );
            break;
          case 'png':
            $Image = ImagePNG( $mImgDest, $sImgDestDir.$sImgOutput );
            break;
          case 'gif':
            $Image = ImagePNG( $mImgDest, $sImgDestDir.$sImgOutput, $iQuality );
        }
        if ( $Image  ) {
          imagedestroy( $mImgDest );
          return $sImgOutput;
        }
        imagedestroy( $mImgDest );
      }
    return null;
    }

  } // end function createThumb

};
?>