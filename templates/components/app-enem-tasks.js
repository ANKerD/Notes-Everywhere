window.getURLParameter = function(name) {
	return decodeURI(
		(RegExp(name + '=' + '(.+?)(&|$)').exec(location.search)||[,null])[1] || ''
	);
};
var DiscItem = React.createClass({
	updateUrl(){
		var did = getURLParameter('dId');
		if (this.props.href != did) {
			var url = '/home.php?dId='+this.props.href;
			history.pushState({dId: this.props.href},this.props.children,url);
		}else {
			//MSG pare de clicar FDP
			console.log('pare de clicar no mermo canto FDP');
		}
	},
	render() {
		// return (
		// 	<li className='list-group-item visible-xs-inline-block visible-lg visible-md visible-sm visible-xs' onClick={this.updateUrl}>
		// 		<a>{this.props.children}</a>
		// 	</li>
		// );
		return (
			<li onClick={this.updateUrl}>
				<a>{this.props.children}</a>
			</li>
		);
	}
});

var NavigationMenu = React.createClass({
	getInitialState() {
		return {
			data: []
		};
	},

	render() {
		var items = this.props.data.map(function(i){
			return <DiscItem key={i.id} href={i.id}>{i.nome}</DiscItem>
		});
		var discs = <ul className="dropdown-menu">
						<DiscItem key={'0'} href={'0'}>Todas as Disciplinas</DiscItem>
						<li role="separator" className="divider"></li>
						{items}</ul>
		// <div>
		// <aside id="sidebar" className="col-sm-3 col-xs-12">
		// <ul className="list-group inline">
		// <DiscItem href='0'><strong>Todas as Disciplinas</strong></DiscItem>
		// {items}
		// </ul>
		// </aside>
		// </div>
		return (
			<nav className="navbar navbar-static navbar-fixed-top navbar-inverse " id="navbar-top">
				<div className="navbar-header">
					<button type="button" className="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-body" aria-expanded="false">
						<span className="sr-only">Toggle navigation</span>
						<span className="icon-bar"></span>
						<span className="icon-bar"></span>
						<span className="icon-bar"></span>
					</button>
					<a className="navbar-brand" href="/home.php">Enem Tasks</a>
				</div>
				<div id="navbar-body" className="navbar navbar-collapse collapse">
					<ul className="nav navbar-nav">
						<li className="dropdown">
							<a href="#" className="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Disciplinas <span className="caret"></span></a>
							{discs}
						</li>
					</ul>
					<ul className="nav navbar-nav navbar-right">
						<li><a href="/logout.php">Sair <span dangerouslySetInnerHTML={{__html: '&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp'}}/></a></li>
					</ul>
				</div>
			</nav>
		);
	}
});

/**************************************/

var NotesAddItem = React.createClass({
	handleSubmit(e){
		e.preventDefault();
		this.props.addItem();
	},
	render() {
		var disciplinas = this.props.disciplinas.map(function(i){
			return <option key={i.id} value={i.id}>{i.nome}</option>
		});
		return (
			<div className="col-xs-12">
				<div className="panel panel-default">
					<div className="panel-heading">
						Adicionar Anotação
					</div>
					<div className="panel-body">
						<form>
							<div className="col-xs-12 form-group">
								<label htmlFor="note-name">Nome daAnotação</label>
								<input ref='note-name' type="text" id="note-name" className='form-control'/>
							</div>
							<div className="col-xs-12 form-group">
								<label htmlFor="note-content">Nome daAnotação</label>
								<textarea ref='note-content' type="text" id="note-content" className='form-control' rows='10'></textarea>
							</div>
							<div className="col-sm-6 col-xs-12 form-group">
								<select ref='disciplina' className='form-control'>
									<option value="" selected disabled>Escolha uma disciplina</option>
									{disciplinas}
								</select>
							</div>
							<div className="col-sm-6 col-xs-12 form-group">
								<button onClick={this.handleSubmit} type='submit' className='btn btn-success btn-block'>Adicionar</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		);
	}
});
var NotesSearch = React.createClass({
	render() {
		return (
			<div className="col-xs-12">
				//TODO
			</div>
		);
	}
});

var NotesView = React.createClass({
	render() {
		return (
			<div>
				//TODO
			</div>
		);
	}
});

var NotesBox = React.createClass({
	render() {
		return (
			<div className="col-xs-12" id="notes-box">
				<NotesAddItem disciplinas={this.props.disciplinas} addItem={this.props.add}/>
				<NotesSearch/>

				<NotesView/>
			</div>
		);
	}
});

/**************************************/

var SchoolNotesBox = React.createClass({
	getInitialState() {
		return {
			discs: []
		};
	},
	addItem(){
		console.log('added');
	},
	loadDisciplinesData(){
		self = this;

		if (localStorage.getItem('disciplinas')) {
			var d = JSON.parse(localStorage.getItem('disciplinas'));
			self.setState({discs: d});
		}

		$.ajax({
			url: '/classes/Disciplinas.php',
			type: 'post',
			dataType: 'json',
			data: {
				action: 'ajaxgetall'
			}
		})
		.done(function(d) {
			console.log("success");
			console.log(d);
			localStorage.setItem('disciplinas', JSON.stringify(d));
			self.setState({discs: d});
		})
		.fail(function() {
			console.log("error");
		})
	},
	componentWillMount() {
		if (getURLParameter('dId')) {
			//passar o did para os estado
			var d = getURLParameter('dId');
			history.pushState({dId: d},'Home',location.href.split('?')[0]+'?dId='+d);
			console.log(location.href.split('?')[0]+'?dId='+d);
		}
		this.loadDisciplinesData();
	},
	render() {
		return (
			<div>
				<NavigationMenu data={this.state.discs}/>
				<NotesBox disciplinas={this.state.discs} add={this.addItem}/>
			</div>
		);
	}
});
ReactDOM.render(<SchoolNotesBox/>,document.getElementById('app-container'));
// [{
// 	name: 'geogra',
// 	id: (int),
// 	notes:[
// 		{
// 			title:'logaritimo',
// 			content: 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Vero, tenetur.',
// 			created: Date.now()
// 		}
// 	]
// }]
