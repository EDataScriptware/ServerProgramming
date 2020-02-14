<?php
    var_dump($_FILES);
    
    // if the file is not empty or does not have error code
    if (!empty($_FILES['uploaded_file']) && $_FILES['uploaded_file']['error'] == 0)
    {
        // check size and type of file (file extension)
        $filename = basename($_FILES['uploaded_files']['name']);
        $ext = substr($filename,strrpos($filename,".")+1);

        $validTypes = ['application/vnd.ms-excel', 
                       'application/xls',
                       'application/octet-stream'];


        if ($ext == "xls" && 
            in_array($_FILES['uploaded_file']['type'],$validType) && 
            $_FILES['uploaded_file']['size'] < 35000) 
        {
            $newname = "./files/$filename";
            
            if(move_uploaded_file($_FILES['uploaded_file']['tmp_name'],$newname))
            {
                chmod($newname, 0644);
                $json = array();
                $json['msg'] = "It's done!";
                $json['error'] = 0;
                echo json_encode($json);
            }
            else 
            {
                $json = array();
                $json['msg'] = "Error: File not saved.";
                $json['error'] = 3;
                echo json_encode($json);
            }
        } 
        else
        {
            
            $json = array();
            $json['msg'] = "Error: only .xls files under 350k";
            $json['error'] = 2;
            echo json_encode($json);
        }
    } 
    else 
    {
        //initialize the array
        $json = array();
        
        //assign the error messages
        $json['msg'] = "Error: No File Uploaded!";
        $json['error'] = 1;
        echo json_encode($json);
    }
    
?>