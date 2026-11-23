<?php
// function validateName($field_list, $field_name){
// 	if (!isset($field_list[$field_name])){
// 		return false;
// 	}
// 	$pattern = "/^[a-zA-Z'-]+$/"; // format nama (alfabet)
// 	if (!preg_match($pattern, $field_list[$field_name])){
// 		return false;
// 	}
// 	return true;
// }

// function validateName(&$errors, $field_list, $field_name){
// 	$pattern = "/^[a-zA-Z'-]+$/"; // format surname (alfabet) 
// 	if (!isset($field_list[$field_name]) || empty($field_list[$field_name])){
// 		$errors[$field_name] = 'required';
// 	} else if (!preg_match($pattern, $field_list[$field_name])){
// 		$errors[$field_name] = 'invalid';
// 	}
// }

    function validateForm(&$errors, $field_list) {
        // surname
        if (empty($field_list['surname'])) {
            $errors['surname'] = 'Surname wajib diisi';
        } else if (!preg_match("/^[a-zA-Z'-]+$/", $field_list['surname'])) {
            $errors['surname'] = 'Surname hanya boleh huruf';
        }

        // email
        if (empty($field_list['email'])) {
            $errors['email'] = 'Email wajib diisi';
        } else if (!filter_var($field_list['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Format email tidak valid';
        }

        // password
        if (empty($field_list['passwd'])) {
            $errors['passwd'] = 'Password wajib diisi';
        } else if (strlen($field_list['passwd']) < 8) {
            $errors['passwd'] = 'Password minimal 8 karakter';
        }

        // address
        if (empty($field_list['address'])) {
            $errors['address'] = 'Alamat wajib diisi';
        }

        // state
        if ($field_list['state'] == -1) {
            $errors['state'] = 'State wajib dipilih';
        }

        // gender
        if (!isset($field_list['sex'])) {
            $errors['sex'] = 'Gender wajib dipilih';
        }
    }

?>