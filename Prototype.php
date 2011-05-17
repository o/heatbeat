<?php

namespace RRD;

class Create {
	const SEPERATOR = ':';

	const PARAM_STEP = '--step';
	const PARAM_START = '--start';
	const PARAM_OVERWRITE = '--no-overwrite';

	const DATASTORE_PREFIX = 'DS';
	const DATASTORE_TYPE_GAUGE = 'GAUGE';
	const DATASTORE_TYPE_COUNTER = 'COUNTER';
	const DATASTORE_TYPE_DERIVE = 'DERIVE';
	const DATASTORE_TYPE_ABSOLUTE = 'ABSOLUTE';

	const RRA_PREFIX = 'RRA';
	const RRA_TYPE_AVERAGE = 'AVERAGE';
	const RRA_TYPE_MIN = 'MIN';
	const RRA_TYPE_MAX = 'MAX';
	const RRA_TYPE_LAST = 'LAST';

	const TIME_NOW = 'N';

	private $filename;
	private $step = 300;
	private $start = self::TIME_NOW;
	private $noOverwrite = false;
	private $datastores = array();
	private $rras = array();

	private function getFilename() {
		return $this->filename;
	}

	public function setFilename($filename) {
		$this->filename = $filename;
		return $this;
	}

	private function getStep() {
		return $this->step;
	}

	public function setStep($step) {
		$this->step = $step;
		return $this;
	}

	private function getStart() {
		return $this->start;
	}

	public function setStart($start) {
		$this->start = $start;
		return $this;
	}

	private function getNoOverwrite() {
		return $this->noOverwrite;
	}

	public function setNoOverwrite($noOverwrite) {
		$this->noOverwrite = $noOverwrite;
		return $this;
	}

	private function getDatastores() {
		return $this->datastores;
	}

	public function addDatastore($name, $type, $heartbeat, $min, $max) {
		$this->datastores[] = self::DATASTORE_PREFIX . self::SEPERATOR . $name . self::SEPERATOR . $type . self::SEPERATOR . $heartbeat . self::SEPERATOR . $min . self::SEPERATOR . $max;
		return $this;
	}

	private function getRras() {
		return $this->rras;
	}

	public function addRra($type, $xff, $steps, $rows) {
		$this->rras[] = self::RRA_PREFIX . self::SEPERATOR . $type . self::SEPERATOR . $xff . self::SEPERATOR . $steps . self::SEPERATOR . $rows;
		return $this;
	}

	function build() {
		$options = new \ArrayObject();
		$options->append(self::PARAM_STEP);
		$options->append($this->getStep());
		$options->append(self::PARAM_START);
		$options->append($this->getStart());
		if ($this->getNoOverwrite())
			$options->append(self::PARAM_OVERWRITE);
		foreach ($this->getDatastores() as $datastore) {
			$options->append($datastore);
		}
		foreach ($this->getRras() as $rra) {
			$options->append($rra);
		}
		$result = \rrd_create($this->getFilename(), \iterator_to_array($options), count($options));
		if ($result) {
			return true;
		} else {
			return false;
		}
	}

}

class Update {
	const SEPERATOR = ':';
	const TIME_NOW = 'N';

	private $filename;
	private $time = self::TIME_NOW;
	private $parameters = array();

	private function getFilename() {
		return $this->filename;
	}

	public function setFilename($filename) {
		$this->filename = $filename;
		return $this;
	}

	private function getTime() {
		return $this->time;
	}

	public function setTime($time) {
		$this->time = $time;
		return $this;
	}

	private function getParameters() {
		return $this->parameters;
	}

	public function setParameters(array $parameters) {
		$this->parameters = $parameters;
		return $this;
	}

	public function build() {
		$result = \rrd_update($this->getFilename(), $this->getTime() . self::SEPERATOR . \implode(self::SEPERATOR, $this->getParameters()));
		if ($result) {
			return true;
		} else {
			return false;
		}
	}

}

class Graph {
	const SEPERATOR = ':';
	const TIME_NOW = 'N';
	const EQUAL = '=';

	const DEF_PREFIX = 'DEF';
	const CDEF_PREFIX = 'CDEF';
	const VDEF_PREFIX = 'VDEF';

	const GPRINT_PREFIX = 'GPRINT';

	const CF_TYPE_AVERAGE = 'AVERAGE';
	const CF_TYPE_MIN = 'MIN';
	const CF_TYPE_MAX = 'MAX';
	const CF_TYPE_LAST = 'LAST';

	const GRAPH_ELEMENT_LINE = 'LINE';
	const GRAPH_ELEMENT_AREA = 'AREA';

	const PARAM_START = '--start';
	const PARAM_END = '--end';
	const PARAM_TITLE = '--title';
	const PARAM_VLABEL = '--vertical-label';
	const PARAM_WIDTH = '--width';
	const PARAM_HEIGHT = '--height';
	const PARAM_UPPER_LIMIT = '--upper-limit';
	const PARAM_LOWER_LIMIT = '--lower-limit';

	private $filename;
	private $start;
	private $end;
	private $title;
	private $verticalLabel;
	private $width;
	private $height;
	private $defs = array();
	private $cdefs = array();
	private $vdefs = array();
	private $graphElements = array();
	private $gprints = array();

	public function getFilename() {
		return $this->filename;
	}

	public function setFilename($filename) {
		$this->filename = $filename;
	}

	public function getStart() {
		return $this->start;
	}

	public function setStart($start) {
		$this->start = $start;
	}

	public function getEnd() {
		return $this->end;
	}

	public function setEnd($end) {
		$this->end = $end;
	}

	public function getTitle() {
		return $this->title;
	}

	public function setTitle($title) {
		$this->title = $title;
	}

	public function getVerticalLabel() {
		return $this->verticalLabel;
	}

	public function setVerticalLabel($verticalLabel) {
		$this->verticalLabel = $verticalLabel;
	}

	public function getWidth() {
		return $this->width;
	}

	public function setWidth($width) {
		$this->width = $width;
	}

	public function getHeight() {
		return $this->height;
	}

	public function setHeight($height) {
		$this->height = $height;
	}

	public function getDefs() {
		return $this->defs;
	}

	public function addDef($vname, $ds_name, $rrdfile, $cf) {
		$this->defs[] = self::DEF_PREFIX . self::SEPERATOR . $vname . self::EQUAL . $ds_name . self::SEPERATOR . $rrdfile . self::SEPERATOR . $cf;
	}

	public function getCdefs() {
		return $this->cdefs;
	}

	public function addCdef($vname, $rpn) {
		$this->cdefs[] = self::CDEF_PREFIX . self::SEPERATOR . $vname . self::SEPERATOR . $rpn;
	}

	public function getVdefs() {
		return $this->vdefs;
	}

	public function addVdef($vname, $rpn) {
		$this->vdefs[] = self::VDEF_PREFIX . self::SEPERATOR . $vname . self::SEPERATOR . $rpn;
	}

	public function getGraphElements() {
		return $this->graphElements;
	}

	public function addGraphElement($type, $value, $color, $legend) {
		$this->graphElements[] = $type . self::SEPERATOR . $value . $color . self::SEPERATOR . $legend;
	}

	public function getGprints() {
		return $this->gprints;
	}

	public function addGprint($vname, $format) {
		$this->gprints[] = self::GPRINT_PREFIX . self::SEPERATOR . $vname . self::SEPERATOR . $format;
	}

	public function build() {
		$options = new \ArrayObject();
		if ($this->getStart()) {
			$options->append(self::PARAM_START);
			$options->append($this->getStart());
		}
		if ($this->getEnd()) {
			$options->append(self::PARAM_END);
			$options->append($this->getEnd());
		}
		if ($this->getTitle()) {
			$options->append(self::PARAM_TITLE . self::EQUAL . $this->getTitle());
		}
		if ($this->getVerticalLabel()) {
			$options->append(self::PARAM_VLABEL . self::EQUAL . $this->getVerticalLabel());
		}
		foreach ($this->getDefs() as $def) {
			$options->append($def);
		}
		foreach ($this->getGprints() as $gprint) {
			$options->append($gprint);
		}
		foreach ($this->getGraphElements() as $elements) {
			$options->append($elements);
		}
		\var_dump($options);
		$result = \rrd_graph($this->getFilename(), \iterator_to_array($options), count($options));
		if ($result) {
			return true;
		} else {
			return \rrd_error();
		}
	}

}


//$newrrd = new \RRD\Create;
//$newrrd->setFilename('test.rrd');
//$newrrd->setStart('-1 day');
//$newrrd->setStep(300);
//$newrrd->addDatastore('loggedusers', \RRD\Create::DATASTORE_TYPE_ABSOLUTE, 600, 0, 'U');
//$newrrd->addRra(\RRD\Create::RRA_TYPE_AVERAGE, 0.5, 1, 128);
//$newrrd->build();

//$rrdupdate = new \RRD\Update();
//$rrdupdate->setFilename('test.rrd');
//$rrdupdate->setTime('N');
//$rrdupdate->setParameters(array(50));
//$rrdupdate->build();

$rrdgraph = new \RRD\Graph();
$rrdgraph->setStart('-1 day');
$rrdgraph->setFilename('test.png');
$rrdgraph->setTitle('title');
$rrdgraph->setVerticalLabel('vertical');
$rrdgraph->addDef('loggedusers', 'test.rrd', 'loggedusers', \RRD\Graph::CF_TYPE_AVERAGE);
$rrdgraph->addGraphElement(\RRD\Graph::GRAPH_ELEMENT_AREA, 'loggedusers', '#CCCCCC', 'Speed');
echo $rrdgraph->build();
?>