<?php
function getsize($file){
$content = file_get_contents($file);   
return strlen($content)/1024;
}
/**
 * 图片压缩类
 *
 * @package App\Http\Controllers\Common
 * @author Ican Bachors
 * @carrier CLZ 19/1/16
 */
class ImgCompressor {

    /**
     * 可供压缩的类型
     */
    private $setting = [
        'file_type' => [
            'image/jpeg',
            'image/png',
            'image/gif'
        ]
    ];

    /**
     * 被处理的图片原始路径
     */
    private $imagePath;

    /**
     * 压缩之后的存储路径
     */
    private $imageCompressPath;

    /**
     * [
     *      "0": 879,
     *      "1": 623,
     *      "2": 2,
     *      "3": "width=\"879\" height=\"623\"",
     *      "bits": 8,
     *      "channels": 3,
     *      "mime": "image/jpeg"
     *  ]
     */
    private $imageInfo;

    private $res = [
        'code' => 0,
        'original' => [
            'name' => 'oldName',
            'type' => 'imageType',
            'size' => 'imageSize'
        ],
        'compressed' => [
            'name' => 'newName',
            'type' => 'imageType',
            'size' => 'imageSize'
        ]
    ];

    function __construct($fileType = false) {
        if ($fileType)
            $this->setting['file_type'] = $fileType;
    }

    /**
     * @param int $level
     * @return ImgCompressor
     * @throws \Exception
     * @author 19/1/17 CLZ.
     */
    public function compress(  $level = 0) {
        if ($level < 0 || $level > 9)
            throw new \Exception(__METHOD__ . 'Compression level: [0, 9]');

        $compressImageName = $this->imageCompressPath;

        $type = $this->imageInfo['mime'];

        $image = ( 'imagecreatefrom' . basename($type) )($this->imagePath);

        if($type == 'image/jpeg'){
            imagejpeg($image, $compressImageName, (100 - ($level * 10)) );
        } else if ($type == 'image/gif') {
            if($this->ifTransparent($image)) { // 保留图片透明状态
                imageAlphaBlending($image, true);
                imageSaveAlpha($image, true);
                imagegif($image, $compressImageName);
            } else
                imagegif($image, $compressImageName);

        } else if($type == 'image/png'){
            if($this->ifTransparent($image)) {
                imageAlphaBlending($image, true);
                imageSaveAlpha($image, true);
                imagepng($image, $compressImageName, $level);
            } else
                imagepng($image, $compressImageName, $level);
        }

        // 销毁图片
        imagedestroy($image);

        $this->res['compressed']['size'] = filesize($compressImageName);

        return $this;
    }

    /**
     * 判断图片是否为 透明 图片
     *
     * @param $image
     * @return bool
     * @author 19/1/16 CLZ.
     */
    private function ifTransparent($image) {
        for($x = 0; $x < imagesx($image); $x++)
            for($y = 0; $y < imagesy($image); $y++)
                if((imagecolorat($image, $x, $y) & 0x7F000000) >> 24) return true;
        return false;
    }

    /**
     * 设置 被压缩图片路径, 压缩之后的存储路径
     * 
     * @param $image
     * @param $compressImageName
     * @return $this
     * @author 19/1/17 CLZ.
     * @throws \Exception
     */
    public function set($image, $compressImageName)
    {
        try {
            $this->imageInfo = getImageSize($image);
        } catch (\Exception $e) {
            throw new \Exception('不是图片类型');
        }

        $this->imagePath = $image;
        $this->imageCompressPath = $compressImageName;

        $this->res['original'] = [
            'name' => $this->imagePath,
            'type' => $this->imageInfo['mime'],
            'size' => filesize($this->imagePath)
        ];

        $this->res['compressed'] = [
            'name' => $this->imageCompressPath,
            'type' => $this->imageInfo['mime'],
            'size' => ''
        ];

        if( in_array($this->imageInfo['mime'], $this->setting['file_type']) )
            return $this;

        throw new \Exception(__METHOD__);
    }

    /**
     * 尺寸变更
     * 
     * @param $width
     * @param $height
     * @return $this
     * @author 19/1/17 CLZ.
     * @throws \Exception
     */
    function resize($width, $height) {

        if($width == 0 && $height > 0) {
            $width = ( $height / $this->imageInfo['1'] ) * $this->imageInfo['0'] ;
        } else if ($width > 0 && $height == 0) {
            $height = ( $width / $this->imageInfo['0'] ) * $this->imageInfo['1'] ;
        } else if ($width <= 0 && $height <= 0) {
            throw new \Exception('illegal size!');
        }

        $imageSrc = ( 'imagecreatefrom' . basename($this->imageInfo['mime']) )($this->imagePath);

        $image = imagecreatetruecolor($width, $height); //创建一个彩色的底图
        imagecopyresampled($image, $imageSrc, 0, 0, 0, 0,$width, $height, $this->imageInfo[0], $this->imageInfo[1]);

        ( 'image' . basename($this->imageInfo['mime']) )($image, $this->imageCompressPath);

        $this->imagePath = $this->imageCompressPath;

        $this->res['compressed']['size'] = filesize($this->imageCompressPath);

        imagedestroy($image);
        imagedestroy($imageSrc);

        return $this;
    }

    /**
     * 获取结果
     * 
     * @return array
     * @author 19/1/17 CLZ.
     */
    public function get()
    {
        return $this->res;
    }
}
/*
$ImgCompressor = new ImgCompressor();
//仅压缩
$result = $ImgCompressor->set('test.jpg', 'test.jpg')->compress(5)->get();
//仅改变尺寸
//$result = $ImgCompressor->set('/vim.jpg', '/resizeOnly.jpg')->resize(500, 500)->get();
//压缩且改变尺寸
//$result = $ImgCompressor->set('/vim.png', '/resizeAndCompress.png')->resize(0, 500)->compress(5)->get();

return $result;
*/
?>