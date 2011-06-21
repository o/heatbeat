Internals of Heatbeat
=====================

File / Folder structure
-----------------------

* bin :	Heatbeat Cli tool living in here. 
* external : This folder contains external scripts (you can place your codes written in different languages) for fetching data. 
* lib :	Base library of Heatbeat 
	* CommandLine : Application and command classes for Cli interface
	* Log :	Handlers and base class for error logging
	* Parser : Config, template and template node parsers 
	* Source : Interfaces for source plugins
		* Plugin : Plugins for fetching data from sources
	* Util : Classes for interacting with shells. 
		* RRDTool :	Implementations of RRDTool commands
* logs : Folder for verbose and error logs
* templates : Contains YAML based graph templates
* rrd :	Place of Round Robin Databases
* vendor : External libraries 
	
	
When you running a CLI command or Web frontend, Heatbeat parses config file (with Heatbeat\Parser\ConfigParser) for your defined templates. 

Creating graphs
---------------
*heatbeat create*

Heatbeat parses your .yml template (with calling `Heatbeat\Parser\TemplateParser`) and finds `datastore`, `step` and `rra` arguments in `rrd` node. After this arguments validating and converting (with classes under `Heatbeat\Parser\Template\Node`) for calling `rrdtool create` command (via `\Heatbeat\Util\RRDTool\CreateCommand`). 

	
	Config Parse --> Template Parse -> Node Arguments Validation -> Converting Nodes as string -> Building command -> RRDTool Create
	

Updating graphs
---------------
*heatbeat update*

Now, Heatbeat uses `source-name` and `items` under graphs node in template. After validating template nodes, inputs passed to Source/Plugin and waits output for updating graphs. If output is successful, Heatbeat builds command for updating Round Robin Database (via `\Heatbeat\Util\RRDTool\CreateCommand`). 

	
	Config Parse --> Template Parse -> Passing parameters to source -> Gathering data from source -> Output validation -> Building command -> RRDTool Update
	

Graphing data
-------------

Well, we need to create nicely graphs for stored data. Heatbeat uses all arguments in `graphs` node in template, validates and outputs to browser (via `\Heatbeat\Util\RRDTool\GraphCommand`). 

	
	Config Parse --> Template Parse -> Node Arguments Validation -> Converting Nodes as string -> Building command -> RRDTool Graph
	
