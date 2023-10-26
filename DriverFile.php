<?php
enum FileType {
    case Dir;
    case Image;
    case Audio;
    case Video;
    case Document;
    case Other;
}

class DriverFile {
    public FileType $type;
    public string $name;
    public int $size;
    public int $modified;
    private string $path;

    public function __construct(string $name, int $modified, string $fileType, int $size, string $path) {
        $this->name = $name;
        $this->modified = $modified;
        $this->size=$size;
        $this->path = $path;
        $this->setType($fileType);
    }

    public function getFileRow() {
        return '<tr>
                    <td>'.$this->getLink().'</td>
                    <td>'.$this->getFilePreview().'</td>
                    <td>'.$this->getSize().'</td>
                    <td>'.$this->getModifyDate().'</td>
                    <td>'.$this->getDeleteIcon().'</td>
                </tr>';
    }

    private function getLink() {
        if($this->name == '..') {
            $endOfParentPath = strrpos($_SERVER['QUERY_STRING'], '/');
            $parentPath = str_split($_SERVER['QUERY_STRING'], $endOfParentPath)[0];
            return '<a href="drive.php?'.$parentPath.'"><i class="bi bi-folder-symlink"></i></a>';
        } else if($this->type === FileType::Dir)
            return '<a href="drive.php?path='.$_GET['path'].'/'.$this->name.'">'.$this->getFileDisplayName().'</a>';
        else
            return  '<a href="'.$this->path.'" download="'.$this->name.'">'.$this->getFileDisplayName().'</a>';
    }

    private function getSize() {
        if($this->size > 1073741824)
            return round($this->size/1073741824, 2)." GB";
        if($this->size > 1048576)
            return round($this->size/1048576, 2)." MB";
        if($this->size > 1024)
            return round($this->size/1024, 2)." KB";
    }

    private function getModifyDate() {
        if($this->name == '..') return '';
        return date('Y-m-d H:i:s',$this->modified);
    }

    private function setType(string $fileType) {
        if($fileType == 'dir')
            $this->type = FileType::Dir;
        else if(str_ends_with($this->name, '.png') || str_ends_with($this->name, '.gif') || str_ends_with($this->name, '.jpg'))
            $this->type = FileType::Image;
        else if(str_ends_with($this->name, '.mp3'))
            $this->type = FileType::Audio;
        else if(str_ends_with($this->name, '.mp4'))
            $this->type = FileType::Video;
        else if(str_ends_with($this->name, '.pdf'))
            $this->type = FileType::Document;
        else
            $this->type = FileType::Other;
    }

    private function getFileDisplayName() {
        $icon = '';
        switch ($this->type) {
            case FileType::Dir:
                $icon = '<i class="bi bi-folder"></i>';
                break;
            case FileType::Image:
                $icon = '<i class="bi bi-image"></i>';
                break;
            case FileType::Audio:
                $icon = '<i class="bi bi-file-music"></i>';
                break;
            case FileType::Video:
                $icon = '<i class="bi bi-file-play"></i>';
                break;
            case FileType::Document:
                $icon = '<i class="bi bi-file-pdf"></i>';
                break;
            case FileType::Other:
                $icon = '<i class="bi bi-file-earmark"></i>';
                break;
            }
        return $icon." ".$this->name;
    }

    private function getDeleteIcon() {
        if($this->name == '..') return '';
        $type = $this->type == FileType::Dir ? 'dir' : 'file';
        return '<a href="drive.php?'.$_SERVER['QUERY_STRING'].'/'.$this->name.'&delete=true&type='.$type.'"><i class="bi bi-trash"></i></a>';
    }

    private function getFilePreview() {
        $preview = '';
        switch ($this->type) {
            case FileType::Image:
                $preview = '<a href="'.$this->path.'"><img class="preview-img" src="'.$this->path.'"></a>';
                break;
            case FileType::Audio:
                $preview = "<audio controls src='".$this->path."'>";
                break;
            case FileType::Video:
                $preview = "<video controls muted width='100'> 
                                <source src='".$this->path."' type='video/mp4'>
                            </video>";
                break;
        }
        return $preview;
    }

}