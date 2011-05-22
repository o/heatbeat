<?php

namespace RRDTool;

class RRD {

	private $filename;
	private $datastores;
	private $rras;

	public function getFilename() {
		return $this->filename;
	}

	public function setFilename($filename) {
		$this->filename = $filename;
	}

	public function getDatastores() {
		return $this->datastores;
	}

	public function addDatastore(Datastore $datastore) {
		$this->datastores[] = $datastore;
	}

	public function getRras() {
		return $this->rras;
	}

	public function addRra(RRA $rra) {
		$this->rras[] = $rra;
	}

}

class Datastore {
	const PREFIX = 'DS';
	const SEPERATOR = ':';

	const TYPE_GAUGE = 'GAUGE';
	const TYPE_COUNTER = 'COUNTER';
	const TYPE_DERIVE = 'DERIVE';
	const TYPE_ABSOLUTE = 'ABSOLUTE';

	const UNLIMITED = 'U';

	private $name;
	private $type;
	private $heartbeat;
	private $min;
	private $max;

	public function getName() {
		return $this->name;
	}

	public function setName($name) {
		$this->name = $name;
	}

	public function getType() {
		return $this->type;
	}

	public function setType($type) {
		$this->type = $type;
	}

	public function getHeartbeat() {
		return $this->heartbeat;
	}

	public function setHeartbeat($heartbeat) {
		$this->heartbeat = $heartbeat;
	}

	public function getMin() {
		return $this->min;
	}

	public function setMin($min) {
		$this->min = $min;
	}

	public function getMax() {
		return $this->max;
	}

	public function setMax($max) {
		$this->max = $max;
	}

	public function build() {
		return self::PREFIX . self::SEPERATOR . $this->getName() . self::SEPERATOR . $this->getType() . self::SEPERATOR . $this->getHeartbeat() . self::SEPERATOR . $this->getMin() . self::SEPERATOR . $this->getMax();
	}

}

class RRA {
	const PREFIX = 'RRA';
	const SEPERATOR = ':';

	const TYPE_AVERAGE = 'AVERAGE';
	const TYPE_MIN = 'MIN';
	const TYPE_MAX = 'MAX';
	const TYPE_LAST = 'LAST';

	private $cf;
	private $xff;
	private $steps;
	private $rows;

	public function getCf() {
		return $this->cf;
	}

	public function setCf($cf) {
		$this->cf = $cf;
	}

	public function getXff() {
		return $this->xff;
	}

	public function setXff($xff) {
		$this->xff = $xff;
	}

	public function getSteps() {
		return $this->steps;
	}

	public function setSteps($steps) {
		$this->steps = $steps;
	}

	public function getRows() {
		return $this->rows;
	}

	public function setRows($rows) {
		$this->rows = $rows;
	}

	public function build() {
		return self::PREFIX . self::SEPERATOR . $this->getCf() . self::SEPERATOR . $this->getXff() . self::SEPERATOR . $this->getSteps() . self::SEPERATOR . $this->getRows();
	}

}

class DEF {
	const PREFIX = 'DEF';
	const SEPERATOR = ':';
	const EQUAL = '=';

	const TYPE_AVERAGE = 'AVERAGE';
	const TYPE_MIN = 'MIN';
	const TYPE_MAX = 'MAX';
	const TYPE_LAST = 'LAST';

	private $vname;
	private $rrd;
	private $datastore;
	private $cf;

	public function getVname() {
		return $this->vname;
	}

	public function setVname($vname) {
		$this->vname = $vname;
	}

	public function getRrd() {
		return $this->rrd;
	}

	public function setRrd(RRD $rrd) {
		$this->rrd = $rrd;
	}

	public function getDatastore() {
		return $this->datastore;
	}

	public function setDatastore(Datastore $datastore) {
		$this->datastore = $datastore;
	}

	public function getCf() {
		return $this->cf;
	}

	public function setCf($cf) {
		$this->cf = $cf;
	}

	public function build() {
		return self::PREFIX . self::SEPERATOR . $this->getVname() . self::EQUAL . $this->getRrd()->getFilename() . self::SEPERATOR . $this->getDatastore()->getName() . self::SEPERATOR . $this->getCf();
	}

}

class GraphElement {
	const SEPERATOR = ':';

	const TYPE_AREA = 'AREA';
	const TYPE_LINE = 'LINE';

	private $type;
	private $value;
	private $color;
	private $legend;

	public function getType() {
		return $this->type;
	}

	public function setType($type) {
		$this->type = $type;
	}

	public function getValue() {
		return $this->value;
	}

	public function setValue($value) {
		$this->value = $value;
	}

	public function getColor() {
		return $this->color;
	}

	public function setColor($color) {
		$this->color = $color;
	}

	public function getLegend() {
		return $this->legend;
	}

	public function setLegend($legend) {
		$this->legend = $legend;
	}

	public function build() {
		return $this->getType() . self::SEPERATOR . $this->getValue() . $this->getColor() . self::SEPERATOR . $this->getLegend();
	}

}

namespace RRDTool\Command;

class Create {
	const PARAM_STEP = '--step';
	const PARAM_START = '--start';
	const PARAM_OVERWRITE = '--no-overwrite';

	private $step;
	private $start;
	private $noOverwrite;
	private $rrd;

	public function getStep() {
		return $this->step;
	}

	public function setStep($step) {
		$this->step = $step;
	}

	public function getStart() {
		return $this->start;
	}

	public function setStart($start) {
		$this->start = $start;
	}

	public function getNoOverwrite() {
		return $this->noOverwrite;
	}

	public function setNoOverwrite($noOverwrite) {
		$this->noOverwrite = $noOverwrite;
	}

	public function getRrd() {
		return $this->rrd;
	}

	public function setRrd(\RRDTool\RRD $rrd) {
		$this->rrd = $rrd;
	}

	public function build() {
		$options = new \ArrayObject();
		$options->append(self::PARAM_STEP);
		$options->append($this->getStep());
		$options->append(self::PARAM_START);
		$options->append($this->getStart());
		if ($this->getNoOverwrite())
			$options->append(self::PARAM_OVERWRITE);
		foreach ($this->getRrd()->getDatastores() as $datastore) {
			$options->append($datastore->build());
		}
		foreach ($this->getRrd()->getRras() as $rra) {
			$options->append($rra->build());
		}
		$result = \rrd_create($this->getRrd()->getFilename(), \iterator_to_array($options), count($options));
		if ($result) {
			return true;
		} else {
			return false;
		}
	}

}

class Update {
	const SEPERATOR = ':';

	private $rrd;
	private $time;
	private $parameters;

	public function getRrd() {
		return $this->rrd;
	}

	public function setRrd(\RRDTool\RRD $rrd) {
		$this->rrd = $rrd;
	}

	public function getTime() {
		return $this->time;
	}

	public function setTime($time) {
		$this->time = $time;
	}

	public function getParameters() {
		return $this->parameters;
	}

	public function setParameters($parameters) {
		$this->parameters = $parameters;
	}

	public function build() {
		$result = \rrd_update($this->getRrd()->getFilename(), $this->getTime() . self::SEPERATOR . \implode(self::SEPERATOR, $this->getParameters()));
		if ($result) {
			return true;
		} else {
			return \rrd_error();
		}
	}

}

class Graph {
	const SEPERATOR = ':';
	const EQUAL = '=';

	const CDEF_PREFIX = 'CDEF';
	const VDEF_PREFIX = 'VDEF';
	const GPRINT_PREFIX = 'GPRINT';

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
	private $lowerLimit;
	private $upperlimit;
	private $defs;
	private $cdefs;
	private $vdefs;
	private $gprints;
	private $graphElements;

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

	public function getLowerLimit() {
		return $this->lowerLimit;
	}

	public function setLowerLimit($lowerLimit) {
		$this->lowerLimit = $lowerLimit;
	}

	public function getUpperlimit() {
		return $this->upperlimit;
	}

	public function setUpperlimit($upperlimit) {
		$this->upperlimit = $upperlimit;
	}

	public function getDefs() {
		return $this->defs;
	}

	public function addDef(\RRDTool\DEF $def) {
		$this->defs[] = $def;
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

	public function getGprints() {
		return $this->gprints;
	}

	public function addGprint($vname, $format) {
		$this->gprints[] = self::GPRINT_PREFIX . self::SEPERATOR . $vname . self::SEPERATOR . $format;
	}

	public function getGraphElements() {
		return $this->graphElements;
	}

	public function addGraphElement(\RRDTool\GraphElement $graphElement) {
		$this->graphElements[] = $graphElement;
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
		if ($this->getLowerLimit()) {
			$options->append(self::PARAM_LOWER_LIMIT . self::EQUAL . $this->getLowerLimit());
		}
		if ($this->getUpperlimit()) {
			$options->append(self::PARAM_UPPER_LIMIT . self::EQUAL . $this->getUpperlimit());
		}
		if ($this->getWidth()) {
			$options->append(self::PARAM_WIDTH . self::EQUAL . $this->getWidth());
		}
		if ($this->getHeight()) {
			$options->append(self::PARAM_HEIGHT . self::EQUAL . $this->getHeight());
		}
		foreach ($this->getDefs() as $def) {
			$options->append($def->build());
		}
		foreach ($this->getCdefs() as $cdef) {
			$options->append($cdef);
		}
		foreach ($this->getVdefs() as $vdef) {
			$options->append($vdef);
		}
		foreach ($this->getGprints() as $gprint) {
			$options->append($gprint);
		}
		foreach ($this->getGraphElements() as $element) {
			$options->append($element->build());
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

namespace Test;

$dailyRra = new \RRDTool\RRA();
$dailyRra->setCf(\RRDTool\RRA::TYPE_AVERAGE);
$dailyRra->setXff(0.5);
$dailyRra->setSteps(1);
$dailyRra->setRows(288);

$random = new \RRDTool\Datastore;
$random->setName('random');
$random->setType(\RRDTool\Datastore::TYPE_GAUGE);
$random->setMin(0);
$random->setMax(\RRDTool\Datastore::UNLIMITED);
$random->setHeartbeat(600);

$rrd = new \RRDTool\RRD();
$rrd->setFilename('/Library/WebServer/Documents/devel/RRD/test.rrd');
$rrd->addDatastore($random);
$rrd->addRra($dailyRra);

//$create = new \RRDTool\Command\Create();
//$create->setStart(strtotime('-1 hour'));
//$create->setRrd($rrd);
//$create->setStep(300);
//$create->build();

//$update = new \RRDTool\Command\Update();
//$update->setRrd($rrd);
//$update->setTime(\strtotime('-15 minutes'));
//$update->setParameters(array(2));
//$update->build();
//
$graph = new \RRDTool\Command\Graph();
$graph->setFilename('/Library/WebServer/Documents/devel/RRD/test.png');
$graph->setLowerLimit(0);
$graph->setTitle('title');
$graph->setVerticalLabel('random');
$graph->setStart(strtotime("-2 hour"));

$def = new \RRDTool\DEF();
$def->setCf(\RRDTool\DEF::TYPE_AVERAGE);
$def->setRrd($rrd);
$def->setDatastore($random);
$def->setVname('random');
$graph->addDef($def);

$area = new \RRDTool\GraphElement();
$area->setColor("#CCC");
$area->setValue("random");
$area->setLegend("Random");
$area->setType(\RRDTool\GraphElement::TYPE_AREA);
$graph->addGraphElement($area);

echo $graph->build();