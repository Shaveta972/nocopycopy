<?php
namespace app\widgets;
use dosamigos\tinymce\TinyMce;

class TextEditor extends TinyMce {
	public $options = ['rows' => 6];
	public $language = 'en';
	public $clientOptions = [
			'plugins' => [
					"advlist autolink lists link charmap print preview anchor",
					"searchreplace visualblocks code fullscreen",
					"insertdatetime media table contextmenu paste"
			],
			'toolbar' => "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
	];
	
}