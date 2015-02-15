<?php namespace Mrcore\Mrcore;

interface UserInterface
{
	public function id();

	public function uuid();

	public function email();

	public function first();

	public function last();

	public function name();

	public function alias();

	public function globalPostID();

	public function homePostID();

	/**
	 * This if user is super admin
	 * @return boolean
	 */
	public function isAdmin();

}