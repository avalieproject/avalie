//##############################################################################
//**************************Janela modal****************************************
//************JModal é uma class que cria janelas modas e ela conta com algumas
// varives e metodos.
// variaves:
//          id        :É o id  da janela que é criada para as  divs esse id é
//          passado para todas,mas, não para o iframe
//
//          idIFRAME  :É o id do iframe que é criado
//
//          nome      : Este nome é passado como parametro no metodo start, mas
//          é opcional ela deve ser passada quando quiser passar um nome para o
//          iframe
//
//          url        : É a url da pagina que quer que seja aberta dentro do
//          iframe
//          largura    : Recebe a largura  que é passado pelo o metodo start
//
//          altura     : Recebe a altura que é passado pelo o metodo start
//
//          Wlargura    : Recebe a largura da tela  do navegador
//
//          Waltura     : Recebe a altura da tela  do navegador
//
//          Flargura    : Recebe variavel  largura menos  a borda
//
//          Faltura     : Recebe a variavel altura que é passado pelo o metodo start menos
//                        o tamanho do topo
//          eixoX       :  recebe a formula (Wlargura-FLargura)/2 para centralizar
//          a janela nop eixo X.
//          eixoY       :  recebe a formula (Waltura-Faltura)/2 para centralizar
//          a janela nop eixo Y.
//
//          eixoZ       : recebe o eixo z que é a profundidade da janela em
//          relação a pagina principal.
//
//          html_dv     : Recebe todo o html Da janela Modal
//
//          html_dvNew  : Não faz nada.
//          modo_de_tela : Recebe o modo inicial da janela que é  'tela_normal',
//
//METODOs:
//         start(url,largura,altura,nome)       : metodo que inicia a JMODAL
//         passando atributos para o metodo setVars(url,largura, altura, nome)
//         e chama o open( )
//         setVars(url,largura, altura, nome)   : Foi criado para iniciar todas
//         as variavs que vai ser utilizada na JMODAL
//          open( )                               : Passa p iframe para o corpo
//          da janela modal
//          close( )                              : É chamando para fechar a
//          JMODALquando é chamado por um evento
//          tclose( )                             : É chamado para fechar a JMODAL
//          altumatica mente depois de uma ação  :
//          tela cheia( )                         : è chamado para por a JMODAL no
//          modo tela cheia que ela fica do tamanho do navegador
//          tela normal( )                         : è chamado para por a JMODAL no
//          modo tela normal que é o tamanho inicial que é passado no metodo start( )
//
//         confg_cs ( )                             : recebe todo o css da pagina
//         e é passado para suas divs 
//##############################################################################
var JModal = {
    id: 0,
    idIFRAME: 0,
    nome: 0,
    url: 0,
    largura: 0,
    altura: 0,
    Waltura: 0,
    Wlargura: 0,
    Faltura: 0,
    Flargura: 0,
    eixoX: 0,
    eixoY: 0,
    eixoZ: 1000,
    html_dv: null,
    html_dvNew: null,
    modo_de_tela: 'tela_normal',
    start: function(url, largura, altura, nome) {//nome é o nome do frame que sera aberto
        this.setVars(url, largura, altura, nome);
        this.open( );
        Layer.tclose( );
    },
    setEvents: function( ) {
    },
    setVars: function(url, largura, altura, nome) {
        this.altura = altura;
        if ($.browser.msie)
            this.largura = largura + 14;
        else
            this.largura = largura + 7;
        this.Waltura = $(window).height( );
        this.Wlargura = $(window).width( );
        this.eixoX = (this.Wlargura - this.largura) / 2;
        this.eixoY = (this.Waltura - this.altura) / 2;
        if (this.eixoY <= 0)
            this.eixoY = 0;
        this.eixoZ = this.eixoZ + 1;
        this.url = url;
        this.id = this.id + 1;
        this.nome = nome || this.id;
        if (this.idIFRAME == 0) {
            this.Flargura = this.largura;
            this.Faltura = this.altura;
            this.idIFRAME = this.idIFRAME + 1;
        }
        this.html_dv = "<div id='corpoJMODAL' class='c" + this.id + "'>                              " +
                "   <div id=\"lightbox-panel\" class='j" + this.id + "'> " +
                "       <div id='topo' class='t" + this.id + "'>                              " +
                "          <span style='position:relative; float:right; right: 12px; top: 12px; font-size:15px;font-family: Arial sans-serif; font-size:16px;'><a id=\"close-panel\" style=' ' class='fechar" + this.id + "' href=\"javascript:void(0)\"><img style='width:26px;' src='http://icons.iconseeker.com/png/fullsize/colored-developers-button/close-blue.png'></a></span>" +
                "       </div>                                       " +
                "   </div>                                           " +
                "   <div id=\"fundo\" class='f" + this.id + "' > </div>                       " +
                "</div>";


    },
    open: function( ) {

        $(this.html_dv).appendTo("body");
        this.confg_css( );
        $(".j" + this.id).append("<iframe src='" + this.url + "' name=" + this.nome + " width='" + this.largura + "' marginwidth=\"0\" height='" + this.altura + "' marginheight=\"0\" align=\"top\" scrolling=\"auto\" frameborder=\"0\"></iframe>");
        $(".f" + this.id + " , .j" + this.id + "").fadeIn(300);
        this.close(this.id);
    },
    close: function(id) {
        $("a.fechar" + this.id).click(function( ) {
            $(".c" + id).fadeOut(1000);
            $(".c" + id).remove( );
        });
    },
    tclose: function(id) {
        $("." + id).remove( );
    },
    tela_cheia: function( ) {
        this.modo_de_tela = 'tela_cheia';
        if ($.browser.msie) {
            //modo tela cheia para o IE
            $("div#lightbox-panel").css({
                'left': 0 + 'px',
                'width': (this.Wlargura) + 'px',
                //'height'  : (this.Waltura)+'px',
                'top': 1 + 'px',
                'border': '0px'
            });
            $("iframe").width(this.Wlargura);
            $("iframe").height(this.Waltura - 20);

        } else {
            //modo tela cheia para os outros Navegadores
            $("div#lightbox-panel").css({
                'left': 0 + 'px',
                'width': (this.Wlargura) + 'px',
                //'height'  : (this.Waltura)+'px',
                'top': 1 + 'px',
                'border': '0px'
            });
            $("iframe").width(this.Wlargura);
            $("iframe").height(this.Waltura - 20);
        }

    },
    tela_normal: function( ) {
        this.modo_de_tela = 'tela_normal';
        this.eixoX = (this.Wlargura - this.Flargura) / 2;
        this.eixoY = (this.Waltura - this.Faltura) / 2;
        if (this.eixoY <= 0)
            this.eixoY = 0;
        $("div#lightbox-panel").css({
            'left': this.eixoX + 'px',
            'width': this.Flargura + 'px',
            // 'height' :this.Faltura+'px',
            'top': this.eixoY + 'px',
            'border': ' 1px solid rgb(127, 0, 0)',
            'border'                 : '8px solid rgba(255, 255, 255, .2)', //#000000',
                    '-webkit-background-clip': 'padding-box', /* for Safari */
            'background-clip': 'padding-box', /* for IE9+, Firefox 4+, Opera, Chrome */
            '-moz-border-radius': '8px',
            'border-radius': '8px',
            '-webkit-border-radius': '8px'
        });
        $("iframe").width(this.Flargura);
        $("iframe").height(this.Faltura);
    }
    ,
    confg_css: function( ) {
        //         $("a#close-panel:visited").css({
        //            'color' :'blue',
        //            'text-decoration':'none'
        //        });
        //        $("a#close-panel").css({
        //            'color' :'blue',
        //            'text-decoration':'none'
        //        });

        //        $("div.j"+this.id).css({
        //            'left'  :this.eixoX+'px',
        //            'width' :this.largura,
        //            'top'   :this.eixoY+'px'
        //        });
        $("div.j" + this.id).css({
            'left': this.eixoX + 'px',
            'width': this.largura,
            'top': this.eixoY + 'px',
            'display': 'none',
            'position': 'fixed',
            'margin': 'auto',
            'background-color': '#EAEAEA',
            'padding': '0px 0px 0px 0px',
            'border': ' 1px solid rgb(127, 0, 0)',
            'border'                 : '8px solid rgba(255, 255, 255, .2)', //#000000',
                    '-webkit-background-clip': 'padding-box', /* for Safari */
            'background-clip': 'padding-box', /* for IE9+, Firefox 4+, Opera, Chrome */
            '-moz-border-radius': '8px',
            'border-radius': '8px',
            '-webkit-border-radius': '8px',
            'z-index': this.eixoZ + 1
        });
        $("div.f" + this.id).css({
            'display': 'none',
            'background': '#000000',
            'opacity': '0.5',
            'filter': 'alpha(opacity=90)',
            'position': 'absolute',
            'top': '0px',
            'left': '0px',
            'min-width': '100%',
            'min-height': '100%',
            'z-index': this.eixoZ
        });
        $("#corpoJMODAL #topo").css({
            'width': '100%',
            'height': '33px',
            'background': '#FFFFFF'
        });
    },
    reSize: function(id_class) {
        this.Waltura = $(window).height( );
        this.Wlargura = $(window).width( );
        this.largura = $("div." + id_class).width( );
        this.altura = $("div." + id_class).height( );

        this.eixoX = (this.Wlargura - this.largura) / 2;
        this.eixoY = (this.Waltura - this.altura) / 2;
        if (this.eixoX <= 0)
            this.eixoX = 0;
        if (this.eixoY <= 0)
            this.eixoY = 0;

        $("div." + id_class).css({
            'left': this.eixoX + 'px',
            'top': this.eixoY + 'px'
        });
    }
}
/*
 *  Layer: classe que carrega camadas na área de mensagem
 *  
 *   Utilizada no lugar das modais, 
 *   Apresentam páginas que contem:
 *     .1 camada principal, identificada por: #principal 
 *     .N camadas secundárias, identificada(s) por: .secundaria
 *    
 *  -métodos
 *  start( )          : metodo que inicia a Layer
 *  setVars( )        : inicia as variáveis da Layer
 *  open( )           : apresenta a Layer
 *  tclose( )         : fecha a Layer
 *  openSecondary( )  : exibe camada secundaria          
 */
var Layer = {
    id: 0,
    nome: 0,
    url: 0,
    largura: 0,
    altura: 0,
    html_dv: null,
    start: function(url, largura, altura, nome) {
        this.setVars(url, largura, altura, nome);
        this.setEvents( );
        this.open( );
    },
    setEvents: function( ) {
        //Fecha camada ao disparar ação fora da mesma
        $('#umdigMboxListHeightdef a, #umdigToolbar a, #umdigMenubar a, #spam.exit').click(function( ) {
            Layer.tclose( );
        });
    },
    setVars: function(url, largura, altura, nome) {
        this.url = url;
        this.largura = $('#message-content').width( );
        this.altura = $(window).height( );
        this.nome = nome || this.id;
        this.id = this.id + 1;
        this.html_dv = "<div id='corpoCAMADA' class='camada" + this.id + "'></div>";
        $(this.html_dv).css({
            'background-color': '#FFFFFF'
        });

        $('#message-list-area').css('height', $(window).height( )); //resimensiona a area de listagem de mensagem pra ficar do tamanho da tela

        window.setInterval(function( ) {
            Layer.resize( );
        }, 1000);

    },
    resize: function( ) {
        this.largura = $('#message-list-area').width( );
        this.altura = $(window).height( );
        $('#corpoCAMADA').width(this.largura).height(this.altura);
        $('#janela' + this.id).width(this.largura).height(this.altura);
        $('#message-list-area').css('height', $(window).height( )); //resimensiona a area de listagem de mensagem pra ficar do tamanho da tela
    },
    open: function( ) {
        // Garante que não há outra camada aberta  
        idOlderLayer = $('#corpoCAMADA').attr('class');
        this.tclose(idOlderLayer);

        // Oculta a área de listagem e mensagem
        $('#tbl-message').children( ).hide( );
        $('#umdigReadMessage').children( ).hide( );
        //esconde a area de leitura de mensagem
        $('#message-read-area').hide( );

        // Adiciona as camadas        
        frame = $('<iframe>')
                .attr({
                    id: 'janela' + this.id,
                    src: this.url,
                    width: this.largura,
                    height: this.altura,
                    scrolling: 'auto',
                    frameborder: '0'
                })
                .ready(function( ) {
                    $(this).hide( );
                })
                .load(function( ) {
                    var parent = $(this);

                    Layer.setEvents(parent);

                    //Esconde as telas secundarias, assim que a página carrega
                    $('.secundaria', parent.contents( )).hide( );
                    //Gatilho/Disparador do openSecondary( )
                    $('.abreCamada', parent.contents( )).on("click", function( ) {
                        top.Layer.openSecondary($('#' + $(this).attr('name'), parent.contents( )));
                    });
                    //Gatilho/Disparador do closeSecondary( )
                    $('.fechaCamada', parent.contents( )).on("click", function( ) {
                        top.Layer.closeSecondary( );
                    });
                    //Gatilho/Disparador do tclose( )
                    $('.fechaLayer', parent.contents( )).on("click", function( ) {
                        top.Layer.tclose('camada' + top.Layer.id);
                    });
                    $(this).show( );
                });

        //Layer.resize( );
        $(this.html_dv).appendTo('#tbl-message');
        $(".camada" + this.id).append(frame);
    },
    tclose: function(id) {
        $("." + id).remove( );
        $('#tbl-message').children( ).show( );
        $('#message-read-area').show( );
    },
    openSecondary: function(secundaria) {
        //Fecha outra camada secundaria se houver
        this.closeSecondary( );

        espacamento = 20;        //Largura do Layer
        LarguraDisponivel = this.largura;
        //Largura da camada a ser aberta
        LarguraSecundaria = $(secundaria).outerWidth( );
        //Largura da camada principal ( http://api.jquery.com/siblings/ )
        LarguraPrincipal = $(secundaria).siblings($('#principal')).outerWidth( );
        //Largura necessaria para exibir Principal E Secundaria
        LarguraNecessaria = (LarguraPrincipal + LarguraSecundaria) + espacamento;

        //Decide como será a exibição
        if (LarguraDisponivel > LarguraNecessaria) { //Exibição paralela
            coordenada = LarguraPrincipal;
            $(secundaria).css('left', coordenada);
            $(secundaria).show( );
        } else { //Exibição sobreposta
            coordenada = (LarguraDisponivel - LarguraSecundaria) - espacamento;
            $(secundaria).css('left', coordenada);
            $(secundaria).show( );
        }
    },
    closeSecondary: function( ) {
        var parent = $('#janela' + this.id);
        $('.secundaria', parent.contents( )).hide( );
    }
}