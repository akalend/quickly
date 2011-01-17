<?php
/**
 * Classe para redimensionamento de imagens com opções para rotacionar e adicionar marca d'agua.
 * 
 * @author Cesar Rodrigo Bagatoli -> e-mail: crbdigo@gmail.com
 * @author ALEXANDRE KALENDAREV (refactoring) -> e-mail:   akalend@mail.ru
 * @version 1.1 
 *
 */
class ImageResize {
    /**
     * Nome da imagem com seu caminho completo, dentro do servidor.
     *
     * @var string
     */
    protected $image;

    /**
     * Tipo da Imagem setado automaticamente (1 = GIF, 2 = JPG, 3 = PNG, 4 = SWF, 5 = PSD, 6 = BMP,
     * 7 = TIFF(intel byte order), 8 = TIFF(motorola byte order), 9 = JPC, 10 = JP2, 11 = JPX, 12 = JB2, 13 = SWC,
     * 14 = IFF, 15 = WBMP, 16 = XBM).
     * Somente serão aceitos os tipos 1, 2 e 3.
     *
     * @var int
     */
    protected $imageType;

    /**
     * the Output Image Type  'gif', 'jpg' and 'png' .
     *
     * @var int
     */
    protected $outType =0;

    
    /**
     * Tamanho vertical da imagem original.
     *
     * @var int
     */
    protected $height;

    /**
     * Tamanho horizontal da imagem original.
     *
     * @var int
     */
    protected $width;

    /**
     * Nome da imagem com seu caminho completo no servidor que será feita uma cópia da original, para preservar a original.
     *
     * @var string
     */
    protected $newImage;
    
    /**
     * Novo tamanho vertical da imagem.
     *
     * @var int
     */
    protected $newHeight;

    /**
     * Novo tamanho horizontal da imagem.
     *
     * @var int
     */
    protected $newWidth;

    /**
     * Nome da imagem com seu caminho completo no servidor que será utilizada como marca d'água.
     *
     * @var string
     */
    protected $waterMarkImage;
    
    /**
     * Tipo da imagem da marca d'agua setado automaticamente (1 = GIF, 2 = JPG, 3 = PNG, 4 = SWF, 5 = PSD, 6 = BMP,
     * 7 = TIFF(intel byte order), 8 = TIFF(motorola byte order), 9 = JPC, 10 = JP2, 11 = JPX, 12 = JB2, 13 = SWC,
     * 14 = IFF, 15 = WBMP, 16 = XBM).
     * Somente serão aceitos os tipos 1, 2 e 3.
     *
     * @var int
     */
    protected $waterMarkImageType;
    
    /**
     * Tamanho vertical da marca d'agua.
     *
     * @var int
     */
    protected $waterMarkImageHeight;
    
    /**
     * Tamanho horizontal da marca d'agua.
     *
     * @var int
     */
    protected $waterMarkImageWidth;
    
    /**
     * Posição onde a marca d'agua será colocada.
     * Valores poderão ser 'topLeft', 'topCenter', 'topRight', 'bottomLeft', 'bottomCenter', 'bottomRight' ou 'center'.
     *
     * @var string
     */
    protected $waterMarkPosition = 'bottomRight';
    
    /**
     * Opacidade da marca d'agua.
     * Valores de 0 a 100.
     *
     * @var integer
     */
    protected $waterMarkOpacity = 50;
    
    /**
     * 1 para redimensionar proporcionalmente a imagem, 0 para permitir distorção.
     *
     * @var int
     */
    protected $proportional = 1;

    /**
     * H para redimensinar proporcionalmente a imagem com base na Horizontal, e V para redimensionar
     * proporcionalmente a imagem com base na Vertical.
     *
     * @var string
     */
    protected $proportionalFlag = 'H';

    /**
     * Numero de graus em que a imagem deverá ser rotacionada.
     * Valor de -360 a 360.
     *
     * @var int
     */
    protected $degrees = 0;

    /**
     * Cor da zona descoberta da imagem após a rotação.
     *
     * @var int
     */
    protected $bgColor = 0;

    /**
     * Construtor
     *
     * @param string $image
     * @access public
     * @return boolean
     */
    public function __construct($image) {
        $this->setImage($image);

        return true;
    }

    /**
     * Seta uma nova imagem para ser tratada e pega as dimensões dela junto com seu tipo.
     *
     * @param string $image
     * @access public
     */
    public function setImage($image) {
        $this->image = $image;

        try {
            $tmp = getimagesize($this->image);
            $this->width  = $tmp[0];
            $this->height  = $tmp[1];
            $this->imageType = $tmp[2];
        }
        catch (Exception $e) {
            throw new Exception("Não foi possível identificar o tamanho da imagem original.");
        }
    }

   /**
     * Set output image type
     *
     * @param string $image
     * @access public
     */
    public function setImageType($type) {
    	
    	switch ( $type ) {
    		case 'gif':
    			$this->outType = 1;
                break;
            case 'jpg':
    			$this->outType = 2;
                break;
            case 'png':
            	 $this->outType = 3;
				break;
            default: 
                throw new Exception("image type not  defined");
                break;
			}
    	
       
    }
 
    
    /**
     * Retorna o caminho e nome da imagem atual.
     *
     * @return string
     * @access public
     */
    public function getImage() {
        return $this->image;
    }

    /**
     * Seta uma imagem para ser criada como cópia da original.
     *
     * @param string $newImage
     * @access public
     */
    public function setNewImage($newImage) {
        $this->newImage = $newImage;
    }

    /**
     * Retorna o caminho e nome da imagem cópia.
     *
     * @return string
     * @access public
     */
    public function getNewImage() {
        return $this->newImage;
    }
    
    /**
     * Seta uma imagem para ser utilizada como marca d'água.
     *
     * @param string $waterMarkImage
     * @access public
     */
    public function setWaterMarkImage($waterMarkImage) {
        $this->waterMarkImage = $waterMarkImage;
    }
    
    /**
     * Retorna o caminho e nome da imagem para marca d'água.
     *
     * @return string
     * @access public
     */
    public function getWaterMarkImage() {
        return $this->waterMarkImage;
    }
    
    /**
     * Seta a posição em que a marca d'agua aparecerá na imagem.
     *
     * @param string $waterMarkPosition
     * @access public
     */
    public function setWaterMarkPosition($waterMarkPosition) {
        if($waterMarkPosition == 'topLeft' || 
           $waterMarkPosition == 'topCenter' || 
           $waterMarkPosition == 'topRight' || 
           $waterMarkPosition == 'bottomLeft' || 
           $waterMarkPosition == 'bottomCenter' || 
           $waterMarkPosition == 'bottomRight' || 
           $waterMarkPosition == 'center') {
            $this->waterMarkPosition = $waterMarkPosition;
        }
        else {
            throw new Exception("Posição da marca d'agua é inválida.");
        }
    }
    
    /**
     * Retorna a posição em que a marca d'agua deve ser colocada.
     *
     * @return string
     * @access public
     */
    public function getWaterMarkPosition() {
        return $this->waterMarkPosition;
    }
    
    /**
     * Seta a opacidade da marca d'agua.
     * Valores de 0 a 100.
     *
     * @param int $waterMarkOpacity
     * @access public
     */
    public function setWaterMarkOpacity($waterMarkOpacity) {
        if($waterMarkOpacity >= 0 && $waterMarkOpacity <= 100) {
            $this->waterMarkOpacity = $waterMarkOpacity;
        }
        else {
            throw new Exception("Opacidade informada é inválida. Use valores de 0 a 100.");
        }
    }
    
    /**
     * Retorna a opacidade que a marca d'agua deverá ter.
     *
     * @return int
     * @access public
     */
    public function getWaterMarkOpacity() {
        return $this->waterMarkOpacity;
    }

    /**
     * Seta o tamanho para o qual a imagem (original ou cópia) será redimensionada.
     *
     * @param int $newHeight
     * @param int $newWidth
     * @access public
     */
    public function setNewSize($newHeight, $newWidth) {
        $this->newHeight = $newHeight;
        $this->newWidth = $newWidth;
    }

    /**
     * 1 para redimensionar proporcionalmente a imagem, 0 para permitir distorção.
     *
     * @param int $proportional
     * @access public
     */
    public function setProportional($proportional) {
        $this->proportional = $proportional;
    }

    /**
     * Retorna se é para ser proporcional ou não.
     *
     * @return integer
     * @access public
     */
    public function getProportional() {
        return $this->proportional;
    }

    /**
     * H para redimensinar proporcionalmente a imagem com base na Horizontal, e V para redimensionar
     * proporcionalmente a imagem com base na Vertical.
     *
     * @param string $proportionalFlag
     * @access public
     */
    public function setProportionalFlag($proportionalFlag) {
        $this->proportionalFlag = $proportionalFlag;
    }

    /**
     * Retorna a base pela qual será mantida a proporção de redimensionamento.
     *
     * @return string
     * @access public
     */
    public function getProportionalFlag() {
        return $this->proportionalFlag;
    }
    
    /**
     * Seta quantos graus em que a imagem deverá ser rotacionada.
     * Valor de -360 a 360.
     *
     * @param int $degrees
     * @access public
     */
    public function setDegrees($degrees) {
        if($degrees > 360 || $degrees < -360) {
            throw new Exception("Ângulo informado incorreto. Valor aceito é de -360 a 360.");
        }
        $this->degrees = $degrees;
    }
    
    /**
     * Retorna o numero de graus em que a imagem deverá ser rotacionada.
     *
     * @return int
     * @access public
     */
    public function getDegrees() {
        return $this->degrees;
    }
    
    /**
     * Seta a cor de fundo que a zona descoberta da imagem, depois de rotacionada, deverá ter.
     *
     * @param int $bgColor
     * @access public
     */
    public function setBgColor($bgColor) {
        $this->bgColor = $bgColor;
    }
    
    /**
     * Retorna a cor de fundo que a zona descoberta da imagem, depois de rotacionada, deverá ter.
     *
     * @return int
     * @access public
     */
    public function getBgColor() {
        return $this->bgColor;
    }

	/**
     * Return actual Height
     *
     * @return int
     * @access public
     */
    public function getHeight() {
        return $this->height;
    }
    
	/**
     * Return actual Width
     *
     * @return int
     * @access public
     */
    public function getWidth() {
        return $this->width;
    }
    /**
     * Retutn image type: (1 = GIF, 2 = JPG, 3 = PNG, 4 = SWF, 5 = PSD, 6 = BMP,
     * 7 = TIFF(intel byte order), 8 = TIFF(motorola byte order), 9 = JPC, 10 = JP2, 11 = JPX, 12 = JB2, 13 = SWC,
     * 14 = IFF, 15 = WBMP, 16 = XBM).
     *
     * @return int
     * @access public
     */
    public function getimageType() {
        return $this->imageType;
    }
    
    /**
     * Faz uma cópia da imagem original e seta ela como $image para ser utilizada preservando a original.
     *
     * @return boolean
     * @access private
     * @uses setImage()
     * @uses getImage()
     * @uses setNewImage()
     * @uses getNewImage()
     */
    private function copyImage() {
        if(!empty($this->image) && !empty($this->newImage)) {
            if(!copy($this->getImage(), $this->getNewImage())) {
                throw new Exception("Não foi possível copiar o arquivo.");
            }
            else {
                $this->setImage($this->getNewImage());
                $this->setNewImage("");
                return true;
            }
        }
        else {
            throw new Exception("Erro. Verifique os atributos 'image' e 'newImage'.");
        }
    }
    
    /**
     * Verifica se todos os atributos necessários para o redimensionamento da imagem foram informados.
     * 
     * @access private
     */
    private function verifyAttributes() {
    	if(empty($this->image)) {
            throw new Exception("Atributo 'image' não definido.");
        }
        if(empty($this->imageType)) {
            throw new Exception("Atributo 'imageType' não definido.");
        }
        if(empty($this->height)) {
            throw new Exception("Atributo 'height' não definido.");
        }
        if(empty($this->width)) {
            throw new Exception("Atributo 'width' não definido.");
        }
        if(empty($this->newHeight)) {
            throw new Exception("Atributo 'newHeight' não definido.");
        }
        if(empty($this->newWidth)) {
            throw new Exception("Atributo 'newWidth' não definido.");
        }
    }

    /**
     * Verifica se todos os atributos necessários para a imagem da marca d'agua foram informados.
     * 
     * @access private
     */
    private function verifyWaterMarkAttributes() {
        if(empty($this->waterMarkImage)) {
            throw new Exception("Atributo 'waterMarkImage' não definido.");
        }
        if(empty($this->waterMarkImageType)) {
            throw new Exception("Atributo 'waterMarkImageType' não definido.");
        }
        if(empty($this->waterMarkImageHeight)) {
            throw new Exception("Atributo 'waterMarkHeight' não definido.");
        }
        if(empty($this->waterMarkImageWidth)) {
            throw new Exception("Atributo 'waterMarkImageWidth' não definido.");
        }
    }

    /**
     * Redimensiona a imagem conforme configurado.
     *
     * @return boolean
     * @access public
     * @uses verifyAttributes()
     * @uses copyImage()
     * @uses getProportional()
     * @uses getProportionalFlag()
     * @uses getImage()
     * @uses getDegrees()
     * @uses getBgColor()
     * @uses getWaterMarkImage()
     * @uses getWaterMarkPosition()
     * @uses verifyWaterMarkAttributes()
     * @uses getWaterMarkOpacity();
     */
    public function make() {
        $this->verifyAttributes();
        
        /**
         * Faz a cópia da imagem caso tenha sido informado um novo nome de arquivo em 'newImage'.
         */
        if(!empty($this->newImage)) {
            $this->copyImage();
        }
        
        /**
         * Calcula a Proporção para o redimencionamento.
         */
        if($this->getProportional() == 1) {
            if($this->getProportionalFlag() == 'H') {
                /**
                 * Calcula o novo tamanho Vertical para ser proporcional.
                 */
                $this->newHeight = round(($this->newWidth * $this->height) / $this->width);
            }
            elseif($this->getProportionalFlag() == 'V') {
                /**
                 * Calcula o novo tamanho Horizontal para ser proporcional.
                 */
                $this->newWidth = round(($this->newHeight * $this->width) / $this->height);
            }
            else {
                throw new Exception("Valor incorreto no atributo 'proportionalFlag'.");
            }
        }
        elseif($this->getProportional() != 0) {
            throw new Exception("Valor incorreto no atributo 'proportional'.");
        }
        
        
        switch ($this->imageType) {
            case 1:
                $img    = imagecreatefromgif($this->getImage());
                $newImg = imagecreate($this->newWidth, $this->newHeight);
                break;
            case 2:
                $img    = imagecreatefromjpeg($this->getImage());
                $newImg = imagecreatetruecolor($this->newWidth, $this->newHeight);
                break;
            case 3:
                $img    = imagecreatefrompng($this->getImage());
                $newImg = imagecreatetruecolor($this->newWidth, $this->newHeight);
                break;
            default:
                throw new Exception("image non defined");
                break;
        }
        
//        echo "<br> <font color='blue'>{$this->imageType} img= {$this->getImage()}</font>";
        try {
//            imagecopyresized($newImg, $img, 0, 0, 0, 0, $this->newWidth, $this->newHeight, $this->width, $this->height);

				imagecopyresampled($newImg, $img, 0, 0, 0, 0, $this->newWidth, $this->newHeight, $this->width, $this->height);
        }
        catch (Exception $e) {
            throw new Exception("no possible redimension a image.");
        }
       
        
        /**
         * Gira a imagem.
         */
        if($this->getDegrees() != 0) {
            try {
                $newImg = imagerotate($newImg, $this->getDegrees(), $this->getBgColor());
                /**
                 * Pega os novos valores para 'newHeight' e 'newWidth'.
                 */
                $this->newWidth = imagesx($newImg);
                $this->newHeight = imagesy($newImg);
            }
            catch (Exception $e) {
                throw new Exception("Não foi possível rotacionar a imagem.");
            }
        }
        
        /**
         * Adicionar uma marca d'agua na imagem pronta.
         */
        if(!empty($this->waterMarkImage)) {
            try {
                $tmp = getimagesize($this->getWaterMarkImage());
                $this->waterMarkImageWidth  = $tmp[0];
                $this->waterMarkImageHeight = $tmp[1];
                $this->waterMarkImageType   = $tmp[2];
                
                if($this->waterMarkImageHeight > $this->newHeight || 
                   $this->waterMarkImageWidth  > $this->newWidth) {
                    throw new Exception("can not redimension image.");
                }
            }
            catch (Exception $e) {
                throw new Exception("undefined image or file is not image type.");
            }
            
            $this->verifyWaterMarkAttributes();
            
            switch ($this->waterMarkImageType) {
                case 1:
                    $markImg = imagecreatefromgif($this->getWaterMarkImage());
                    break;
                case 2:
                    $markImg = imagecreatefromjpeg($this->getWaterMarkImage());
                    break;
                case 3:
                    $markImg = imagecreatefrompng($this->getWaterMarkImage());
                    break;
                default:
                    throw new Exception("undefined image type");
                    break;
            }
            
            /**
             * Calcula a área onde será colocada a marca d'agua.
             */
            switch($this->getWaterMarkPosition()) {
                case 'topLeft':
                    $x = 10;
                    $y = 10;
                    break;
                case 'topCenter':
                    $x = round(($this->newWidth / 2) - ($this->waterMarkImageWidth / 2));
                    $y = 10;
                    break;
                case 'topRight':
                    $x = $this->newWidth - $this->waterMarkImageWidth - 10;
                    $y = 10;
                    break;
                case 'bottomLeft':
                    $x = 10;
                    $y = $this->newHeight - $this->waterMarkImageHeight - 10;
                    break;
                case 'bottomCenter':
                    $x = round(($this->newWidth / 2) - ($this->waterMarkImageWidth / 2));
                    $y = $this->newHeight - $this->waterMarkImageHeight - 10;
                    break;
                case 'bottomRight':
                    $x = $this->newWidth - $this->waterMarkImageWidth - 10;
                    $y = $this->newHeight - $this->waterMarkImageHeight - 10;
                    break;
                case 'center':
                    $x = round(($this->newWidth / 2) - ($this->waterMarkImageWidth / 2));
                    $y = round(($this->newHeight / 2) - ($this->waterMarkImageHeight / 2));
                    break;
                default:
                    $x = 10;
                    $y = 10;
            }
            
            /**
             * Adiciona a marca d'agua na imagem.
             */
            try {
                imagecopymerge($newImg, $markImg, $x, $y, 0, 0, $this->waterMarkImageWidth, $this->waterMarkImageHeight, $this->getWaterMarkOpacity());
            }
            catch (Exception $e) {
                throw new Exception("Não foi possível adicionar marca d'agua.");
            }
        }

        
        if ( $this->outType != 0 )
			$this->imageType = $this->outType;

        
        /**
         * Grava a imagem em arquivo.
         */
        try {
            switch ($this->imageType) {
            	case 1:
            		imagegif($newImg, $this->getImage());
            		break;
            	case 2:
            		imagejpeg($newImg, $this->getImage(), 90);
            		break;
            	case 3:
            		imagepng($newImg, $this->getImage());
            		break;
            	default:
            	    throw new Exception("Tipo de imagem informado não é compatível.");
            		break;
            }
        }
        catch (Exception $e) {
            throw new Exception($e);
        }
        
        return true;
    }
}
?>