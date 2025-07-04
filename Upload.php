<?php
class Upload {
    private $file;
    private $targetDir;
    private $maxSize;
    private $allowedTypes;

    /*
    * $file: The file which we are uploading
    * $targetDir: The folder where we will upload the image
    * $maxSize: The maximum size that can be uploaded, in our case 2000000 (bytes) = 2 mb
    * $allowedTypes: Only the selected file types can be uploaded
    */
    public function __construct($file, $targetDir = "uploads/", $maxSize = 2000000, $allowedTypes = ['jpg', 'jpeg', 'png']) {
        $this->file = $file;
        $this->targetDir = $targetDir;
        $this->maxSize = $maxSize;
        $this->allowedTypes = $allowedTypes;
    }

    public function uploadFile() {
        $fileName = pathinfo($this->file['name'], PATHINFO_FILENAME); // Extracts the file name without the extension
        $fileExt  = strtolower(pathinfo($this->file['name'], PATHINFO_EXTENSION)); // Extracts the file extension
        $fileSize = $this->file['size']; //Extracts the size
        /* When a file is uploaded via a form, it is stored in a temporary location on the server
        before it is moved to the final destination. This line of code retrieves the temporary
        filename of the uploaded file. */
        $fileTmp  = $this->file['tmp_name'];

        /* Check file type
        * `in_array(searchThisValue, arrayOfValues)` checks if a value exists in an array
        * It takes two parameters, first one is the value you want to search, and second one
        * is the array where you want to search
        */
        if (!in_array($fileExt, $this->allowedTypes)) {
            return ['status' => false, 'message' => 'Invalid file type.'];
        }

        // Check file size
        if ($fileSize > $this->maxSize) {
            return ['status' => false, 'message' => 'File too large.'];
        }

        // Create target directory (in our case, "uploads" folder) if not exists
        if (!file_exists($this->targetDir)) {
            mkdir($this->targetDir, 0777, true); //`mkdir` command creates a folder
        }

        // Create unique file name to avoid overwriting files with the same name
        // `uniqid()` generates a unique ID based on the current time in microseconds
        $newName = $fileName . uniqid() . '.' . $fileExt; // Generates a unique name for the file using a unique ID
        $destination = $this->targetDir . $newName;

        // Move file
        if (move_uploaded_file($fileTmp, $destination)) {
            return ['status' => true, 'file_name' => $newName]; // If the file is successfully moved to the target directory, return the new file name
        } else {
            return ['status' => false, 'message' => 'File upload failed.']; // If the file could not be moved to the target directory, return false
        }
        return ['status' => false, 'message' => 'File upload failed.'];
    }
}
?>
