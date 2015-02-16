<?php namespace Mrcore\Forms;

use Illuminate\Validation\Factory as Validator;
use Mrcore\Exceptions\FormValidationException;

abstract class FormValidator
{

	/**
	 * @var Validator
	 */
	protected $validator;

	protected $validation;

	/**
	 * @param Validator $validator
	 */
	public function __construct(Validator $validator)
	{
		$this->validator = $validator;
	}

	/**
	 * Validate
	 * @param  array  $formData
	 * @throws Mrcore\Exceptions\FormValidationException
	 */
	public function validate(array $formData)
	{
		$this->validation = $this->validator->make($formData, $this->getValidationRules());
		
		if ($this->validation->fails()) {
			throw new FormValidationException('Validation failed', $this->getValidationErrors());
		}

		// All passed
		return true;

	}

	/**
	 * Get validation rules
	 * @return mixed
	 */
	private function getValidationRules()
	{
		return $this->rules;
	}

	/**
	 * Get validation errors
	 * @return mixed
	 */
	private function getValidationErrors()
	{
		return $this->validation->errors();
	}


}