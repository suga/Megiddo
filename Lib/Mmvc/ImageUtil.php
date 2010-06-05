<?php
/**
 * util de imagens
 *
 * @author Otavio Luiz <otaviolcarvalho@gmail.com>
 *
 */
class ImageUtil {
        /**
         * @param string $arquivo
         * @param string $extensao
         * @param string $nome
         * @param string $pasta
         * @param int $lar - largura da img
         * @param int $alt - altura da img
         * @return boolean
         */
    	static public function uploadImagem($arquivo, $extensao, $nome, $pasta, $lar, $alt) {
            if(!$arquivo) return false;
   
            #Verifica se a imagem esta em um formato valido
            if (!eregi("^image\/(pjpeg|jpeg|png|gif|jpg)$", $extensao)):
                return false;
            endif;
            
            # Define o nome da imagem
            $nomeImagem = $nome;
            //Inicia a criação das miniaturas
            $tam = getimagesize($arquivo);
            $maxWidth = $lar;
            $maxHeight = $alt;
            # Carrega a imagem
            $img = $arquivo;
            # identifica o tipo de imagem
            switch($extensao):
                case ("image/gif"):
                        $img = imagecreatefromgif($arquivo);
                        break;
                case ('image/png'):
                        $img = imagecreatefrompng($arquivo);
                        break;
                case ('image/bmp'):
                        $img = imagecreatefromwbmp($arquivo);
                        break;
                default:
                        $img = imagecreatefromjpeg($arquivo);
                        break;
            endswitch;

            //Pega o tamanho da imagem e proporção de resize
            $width  = imagesx($img);
            $height = imagesy($img);
            $scale  = min($maxWidth/$width, $maxHeight/$height);
            //Se a imagem é maior que o permitido, reduza-a!
            if ($scale < 1) :
                $new_width = floor($scale*$width);
                $new_height = floor($scale*$height);
                // Cria uma imagem temporária
                $tmp_img = imagecreatetruecolor($new_width, $new_height);
                // Copia e resize a imagem velha na nova
                imagecopyresampled($tmp_img, $img, 0, 0, 0, 0,$new_width, $new_height, $width, $height);
                imagedestroy($img);
                $img = $tmp_img;
            endif;
            if(!(imagejpeg($img, "$pasta/".$nomeImagem, 85))){
                return false;
            }else{
                chmod($pasta . "/" . $nomeImagem, 0777);
                return true;
            }
      }
}
?>
