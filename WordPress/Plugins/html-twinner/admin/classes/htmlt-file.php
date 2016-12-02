<?php

class htmltf {
	
	// Declaring private variables
	private $_fname;
	private $_fpath;
	private $_fcontent;

	// Setter functions
	public function setFname($fname) {
	$this->_fname = $fname; }
	public function setFpath($fpath) {
	$this->_fpath = $fpath; }
	public function setFcontent($fcontent) {
	$this->_fcontent = $fcontent; }
	
	// Getter functions
	public function getFname() {
	return $this->_fname; }
	public function getFpath() {
	return $this->_fpath; }
	public function getFcontent() {
	return $this->_fcontent; }
	
}