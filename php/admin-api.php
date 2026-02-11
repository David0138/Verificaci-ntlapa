<?php

// License Management Class
class LicenseManager {
    private $licenses = [];

    // Add a new license
    public function addLicense($license) {
        if (!in_array($license, $this->licenses)) {
            $this->licenses[] = $license;
            return "License added: $license";
        } else {
            return "License already exists: $license";
        }
    }

    // Delete a license
    public function deleteLicense($license) {
        $key = array_search($license, $this->licenses);
        if ($key !== false) {
            unset($this->licenses[$key]);
            return "License deleted: $license";
        } else {
            return "License not found: $license";
        }
    }

    // List all licenses
    public function listLicenses() {
        if (empty($this->licenses)) {
            return "No licenses available.";
        } else {
            return $this->licenses;
        }
    }
}

?>