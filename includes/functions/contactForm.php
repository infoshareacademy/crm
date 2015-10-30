<?php

function contactForm($newContact, $error)
{
    $fields = [
        'surname' => 'Surname',
        'name' => 'Name',
        'position' => 'Position',
        'phone' => 'Phone',
        'email' => 'E-mail',
        'city' => 'City',
        'linkedin' => 'LinkedIn'

    ];

    $output = '';

    $output .= '<form action="?" method="post" enctype="multipart/form-data">';

    foreach ($fields as $fieldName => $fieldLabel) {
        $output .= $fieldLabel . ": <input name ='$fieldName' value='{@$newContact->$fieldName()}' /><br />";
        $output .= "<div style='color: #f00;'>{@$error[$fieldName]}</div>";
    }

    $output .= 'Note:<textarea name="note">' . @$newContact->note() . '</textarea><br/>';
    $output .= '<div style="color:#f00;">' . @$error['note'] . '</div>';

    $output .= '<input type="hidden" name="id" value="' . @$newContact->id() . '">';
    $output .= '<input type="submit" name="send" value="SEND"/>';
    $output .= '</form>';

    return $output;

}