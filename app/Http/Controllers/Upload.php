<?php

namespace App\Http\Controllers;

use App\File;
use Illuminate\Support\Facades\Storage;

class Upload extends Controller
{

    //$request, $path, $upload_type, $delete_file=null, $new_name = null, $crud_type = []
    public function upload($data = [])
        {
            if(in_array('new_name', $data)) {
            $new_name = $data['new_name'] === null ? time() : $data['new_name'];
        }
        if (request()->hasFile($data['file']) && $data['upload_type'] == 'single') {
            Storage::has($data['delete_file']) ? Storage::delete($data['delete_file']) : '';
            return request()->file($data['file'])->store($data['path']);  //return path to save in DB

        }elseif(request()->hasFile($data['file']) && $data['upload_type'] == 'files') {

            $file = request()->file($data['file']);

            $size = $file->getSize();
            $mime_type = $file->getMimeType();
            $name = $file->getClientOriginalName();
            $hashName = $file->hashName();

            $file->store($data['path']);

            $add = File::create([
                'name'        => $name,
                'size'        => $size,
                'file'        => $hashName,
                'path'        => $data['path'],
                'full_file'   => $data['path'] . '/' . $hashName,
                'mime_type'   => $mime_type,
                'file_type'   => $data['file_type'],
                'relation_id' => $data['relation_id'],
            ]);
            return $add->id;
        }
    }


    public function delete($id) {
        $file = File::find($id);
        if(!empty($file)) {
            Storage::delete($file->full_file);
            $file->delete();
        }
    }

    public function delete_files($product_id) {
        $files = File::where('relation_id', $product_id)->where('file_type', 'product')->get();
        if($files->count() > 0) {
            foreach($files as $file) {
                $this->delete($file->id);
                Storage::deleteDirectory($file->path);
            }
        }
    }
}
