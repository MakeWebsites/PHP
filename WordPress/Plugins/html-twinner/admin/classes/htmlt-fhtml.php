<?php

class html_d {
	
	// Declaring private variables
	private $_dname;
	private $_dpath;
	private $_dcontent;

	// Setter functions
	public function setDname($dname) {
	$this->_fname = $dname; }
	public function setDpath($dpath) {
	$this->_fpath = $dpath; }
	public function setDcontent($dcontent) {
	$this->_fcontent = $dcontent; }
	
	// Getter functions
	public function getDname() {
	return $this->_dname }
	public function getDpath() {
	return $this->_dpath }
	public function getDcontent() {
	return $this->_dcontent }
	
}