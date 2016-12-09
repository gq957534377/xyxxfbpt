<?php
/**
 * TOP API: taobao.top.ipout.get Request
 * 
 * @author auto create
 * @since 1.0, 2016.08.30
 */
class TopIpoutGetRequest
{
	
	private $apiParas = array();
	
	public function getApiMethodName()
	{
		return "taobao.top.ipout.get";
	}
	
	public function getApiParas()
	{
		return $this->apiParas;
	}
	
	public function check()
	{
		
	}
	
	public function putOtherTextParam($key, $value) {
		$this->apiParas[$key] = $value;
		$this->$key = $value;
	}
}
