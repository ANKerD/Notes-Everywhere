//função para pegar parâmetros da url
window.getURLParameter = function(name) {
	return decodeURI(
		(RegExp(name + '=' + '(.+?)(&|$)').exec(location.search)||[,null])[1] || ''
	);
};

//componente usado no menu de navegaçao
var DiscItem = React.createClass({
	updateUrl(){
		var did = getURLParameter('dId');
		if (this.props.href != did) {
			//mudar a URL e o estado da página sem que seja necessário recarregar
			var url = '/home.php?dId='+this.props.href;
			history.pushState({dId: this.props.href},this.props.children,url);

			//Atualiza o conteudo sendo exibido
			this.props.changeDisplay(this.props.children);
			this.props.changeContent();
		}else {
			console.log('pare de clicar no mermo canto F******');
		}
	},
	render() {
		return (
			<li onClick={this.updateUrl}>
				<a>{this.props.children}</a>
			</li>
		);
	}
});

//Munu de navegação superior
var NavigationMenu = React.createClass({
	getInitialState() {
		return {
			display_nav: 'Todas as Disciplinas'
		};
	},

	//Muda o nome ecibido pelo menu drop-down sempre que o usuário eschole uma disciplina difrente
	changeDisplay: function(display){
		this.setState({display_nav:display});
	},

	render() {
		var self = this;
		var items = this.props.data.map(function(i){
			return <DiscItem key={i.id} href={i.id} changeContent={self.props.handleStateChange} changeDisplay={self.changeDisplay}>
				{i.name}</DiscItem>
		});

		//Dropdown com a lsta de disciplinas
		var discs = <ul className="dropdown-menu">
						<DiscItem key={'0'} href={'0'} changeContent={this.props.handleStateChange} changeDisplay={this.changeDisplay}>Todas as Disciplinas</DiscItem>
						<li role="separator" className="divider"></li>
						{items}</ul>;

		//Renderiza o menu de navegação e atrela seus respectivos eventos
		return (
			<nav className="navbar navbar-static navbar-fixed-top navbar-inverse " id="navbar-top">
				<div className="navbar-header">
					<button type="button" className="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-body" aria-expanded="false">
						<span className="sr-only">Toggle navigation</span>
						<span className="icon-bar"></span>
						<span className="icon-bar"></span>
						<span className="icon-bar"></span>
					</button>
					<a className="navbar-brand" href="/home.php">Notes Everywhere</a>
				</div>
				<div id="navbar-body" className="navbar navbar-collapse collapse">
					<ul className="nav navbar-nav">
						<li className="dropdown">
							<a href="#" className="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{this.state.display_nav} <span className="caret"></span></a>
							{discs}
						</li>
					</ul>
					<ul className="nav navbar-nav navbar-right">
						<li><a href="logout.php">Sair <span dangerouslySetInnerHTML={{__html: '&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp'}}/></a></li>
					</ul>
				</div>
			</nav>
		);
	}
});

/**************************************/

//Formulário para adicionar novas anotações
var NotesAddItem = React.createClass({
	handleSubmit(e){
		e.preventDefault();

		//Captura as entradas
		var name = $(this.refs.name);
		var content = $(this.refs.content);
		var disc = $(this.refs.disciplina);

		//verifica se foram informados dados válidos
		if (name.val().length > 0 && content.val().length > 0 && disc.val() != -1 && disc.val()) {
			//adiiciona os dados
			this.props.addItem(name.val(),content.val(),disc.val());

			//limpa o formulário
			name.val('');
			content.val('');
			disc.val(-1);

		}else {
			//mensagem informando o que o usuáriodeve corrigir para poder prosseguir
			var msg = '';
			if (name.val().length == 0) {
				msg += 'Preencha o campo nome\n';
			}

			if (content.val().length == 0) {
				msg += 'Preencha o campo conteúdo\n';
			}

			if (disc.val() || !disc.val()) {
				msg += 'Selecione uma disciplina';
			}

			alert(msg);
		}
	},

	//Renderiza o formulário para adicionar disciplinas e atrela seus respectivos eventos
	render() {
		var disciplinas = this.props.disciplinas.map(function(i){
			return <option key={i.id} value={i.id}>{i.name}</option>
		});
		return (
			<div className="col-xs-12">
				<div className="panel panel-default">
					<div className="panel-heading">
						<h3>Adicionar Anotação</h3>
					</div>
					<div className="panel-body">
						<form onSubmit={this.handleSubmit}>
							<div className="col-xs-12 form-group">
								<label htmlFor="note-name"><h5>Nome da Anotação</h5></label>
								<input ref='name' type="text" id="note-name" className='form-control'/>
							</div>
							<div className="col-xs-12 form-group">
								<label htmlFor="note-content"><h5>Anotação</h5></label>
								<textarea ref='content' type="text" id="note-content" className='form-control' rows='10'></textarea>
							</div>
							<div className="col-sm-6 col-xs-12 form-group">
								<select ref='disciplina' className='form-control' defaultValue='-1'>
									<option value="-1" disabled>Escolha uma disciplina</option>
									{disciplinas}
								</select>
							</div>
							<div className="col-sm-6 col-xs-12 form-group">
								<button type='submit' className='btn btn-success btn-block'>Adicionar</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		);
	}
});

//Futuramente será adicionado um formulário para realizr buscas por conteúdo
var NotesSearch = React.createClass({
	render() {
		return (
			<div className="col-xs-12">
				//TODO
			</div>
		);
	}
});

//Componente para exibir visualmente a anotação
var NoteItem = React.createClass({
	render() {
		return (
			<div className="col-xs-12 col-sm-6 col-md-4 col-lg-3">
				<div className="panel panel-default">
					<div className="panel-heading">
						<h3 className="panel-title">{this.props.title}</h3>
					</div>
					<div className="panel-body">
						{this.props.children}
					</div>
				</div>
			</div>
		);
	}
});


//Componente container para as anotações
var NotesView = React.createClass({
	render() {
		var dId = 0;
		if (window.history.state.dId) {
			dId = window.history.state.dId;
		}

		var nts = [];

		//itera o array com os dados das anotações e prepara os NotesItens para renderização
		if (dId == 0) {
			for (var i = 0; i < this.props.content.length; i++) {
				var d = this.props.content[i];
				var n = d.notes;
				for (var j = 0; j < n.length; j++) {
					nts.push(<NoteItem key={n[j].id} title={n[j].title} parent={d.id}>{n[j].content}</NoteItem>);
				}
			}
		}else {
			for (var i = 0; i < this.props.content.length; i++) {
				var d = this.props.content[i];
				if (d.id == dId) {
					var n = d.notes;
					for (var j = 0; j < n.length; j++) {
						nts.push(<NoteItem key={n[j].id} title={n[j].title} parent={d.id}>{n[j].content}</NoteItem>);
					}
				}
			}
		}
		return (
			<div className="col-xs-12">
				{nts}
			</div>
		);
	}
});


/**************************************/

//Elemento pai. nele estão armazenados todos os dados necessários para o
// funcionamento do web app e as respectivas funções para o fluxo de dados entre
// o dispositivo do usuário e o servidor
var SchoolNotesBox = React.createClass({
	getInitialState() {
		return {
			content: [],
			displayContent:[]
		};
	},

	// função que recebe todas as mudanças de da o devido tratamento
	dataChange(d){
		//armazena todos os dados na memório
		this.setState({content: d});

		//armazena todos os dados no dispositivo do usuário memória (ROM)
		localStorage.setItem('content', JSON.stringify(d));

		if (!history.state.dId || history.state.dId == 0) {
			//define quais dados devem ser exibidos
			this.setState({displayContent: d})
		}else {
			//descobre quais dados que devem ser exibidos
			for (var i = 0; i < d.length; i++) {
				var c = d[i];
				if (c.id == history.state.dId) {
					//define quais dados devem ser exibidos
					this.setState({displayContent: [c]});
				}
			}
		}
	},

	//adiciona item quando ele é sincronizado com o servidor
	addItem(name,cont,disc){
		for (var i = 0; i < this.state.content.length; i++) {

			if (this.state.content[i].id == disc) {
				var d = this.state.content;
				var n = {content: cont,
							hora: Date.now(),
							title: name,
							disc: disc};

				var self = this;
				var dIndex = i;

				// enviapara o servidpr a nova anotação
				$.ajax({
					url: 'classes/Disciplinas.php',
					type: 'POST',
					dataType: 'json',
					data: {
						action: 'addNote',
						note: JSON.stringify(n)
					}
				})
				.done(function(data) {
					// ela só é exibida para o usuário a partir do momento em que
					// foi confirmado que o servidor possui tais dados
					var d = self.state.content;
					d[dIndex].notes.push(data);
					self.dataChange(d);
				})
				.fail(function() {
					console.log("error ao mandar pro servidor");
				})
			}
		}
	},

	//carrega os dados do servidor
	loadData(){
		self = this;

		if (localStorage.getItem('content')) {
			var d = JSON.parse(localStorage.getItem('content'));
			self.dataChange(d);
		}

		$.ajax({
			url: 'classes/Disciplinas.php',
			type: 'post',
			dataType: 'json',
			data: {
				action: 'ajaxGetContent'
			}
		})
		.done(function(d) {
			self.dataChange(d);
		})
		.fail(function() {
			console.log("error");
		})
	},
	componentWillMount() {

		//Atualiza o conteúdo sempre que a URL muda
		window.onpopstate = function(){
			self.stateChange();
		};

		//define o o conteudo a ser exibido consultando a URL
		if (getURLParameter('dId')) {
			//parametro did informa qual disciplina deve ser mostrada. Caso seja 0 todas serão exibidas;
			var d = getURLParameter('dId');
			history.replaceState({dId: d},'Home',location.href.split('?')[0]+'?dId='+d);
		}else {
			history.replaceState({dId: 0},'Home',location.href.split('?')[0]+'?dId=0');
		}
		this.loadData();
		var self = this;
	},

	//Altera o conteudo quando a URL muda
	stateChange(){
		this.dataChange(this.state.content);
	},
	render() {
		return (
			<div>
				<NavigationMenu data={this.state.content} handleStateChange={this.stateChange}/>
				<div id="notes-box">
					<NotesAddItem disciplinas={this.state.content} addItem={this.addItem}/>

					<NotesView content={this.state.displayContent}/>
				</div>
			</div>
		);
	}
});

//Renderiza o container do aplicativo para a exibiição do app
ReactDOM.render(<SchoolNotesBox/>,document.getElementById('app-container'));
