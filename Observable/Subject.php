<?php 
	namespace Observable;

	use Observable\Observer;

	interface Subject
	{
	    public function registerObserver(Observer $o);
	    public function removeObserver(Observer $o);
	    public function NotifyObserver();
	}