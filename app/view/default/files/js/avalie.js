$('document').ready(function() {
    Main.setEvents();
});
var Main = {
    'setEvents': function() {
        $('#cadastrar-link').click(function() {
            Main.abreCadastro();
        });
        $('#login-link').click(function() {
            Main.abreLogin();
        });
    },
    'abreCadastro': function() {
        JModal.start(cache.url + 'usuario/cadastrar', 300, 400, 'USUARIO_CADASTRAR');
    },
    'abreLogin': function() {
        JModal.start(cache.url + 'login/', 300, 300, 'USUARIO_LOGIN');
    }
};
var usuarioCadastro = {
    'setEvents': function() {
        var enviaCadastro = null;
        $('#usuario-cadastrar-submit').click(function() {
            clearTimeout(enviaCadastro);
            if (usuarioCadastro.validarDados()) {
                enviaCadastro = setTimeout(function() {
                    usuarioCadastro.enviaCadastro();
                }, 500);
            }
        });
    },
    'validarDados': function() {
        if ($('#nome').val() == '') {
            $('#msg-return').addClass('erro');
            $('#msg-return').html('Informe seu nome.');
            $('#nome').focus();
            return false;
        }
        else if ($('#email').val() == '') {
            $('#msg-return').addClass('erro');
            $('#msg-return').html('Informe seu email.');
            $('#email').focus();
            return false;
        }
        else if ($('#senha').val() == '') {
            $('#msg-return').addClass('erro');
            $('#msg-return').html('Informe a senha.');
            $('#senha').focus();
            return false;
        }
        else if ($('#senha-confirmacao').val() == '') {
            $('#msg-return').addClass('erro');
            $('#msg-return').html('Confirme a senha.');
            $('#senha-confirmacao').focus();
            return false;
        }
        else if ($('#senha-confirmacao').val() != $('#senha').val()) {
            $('#msg-return').addClass('erro');
            $('#msg-return').html('Senha e confirmação não conferem.');
            $('#senha-confirmacao').focus();
        }
        else {
            $('#msg-return').removeClass('erro');
            $('#msg-return').html('');
            return true;
        }
    },
    'enviaCadastro': function() {
        var StNome = $('#nome').val();
        var StEmail = $('#email').val();
        var StSenha = $('#senha').val();
        var StConfirmaSenha = $('#senha-confirmacao').val();
        var StData = 'ArUsuario[StNome]=' + StNome + '&ArUsuario[StEmail]=' + StEmail + '&ArUsuario[StSenha]=' + StSenha + '&ArUsuario[StConfirmaSenha]=' + StConfirmaSenha;
        request.sendRequest('post', cache.url + 'usuario/xhrCadastrarSubmit', StData, usuarioCadastro.cadastroCallBack);
    },
    'cadastroCallBack': function(response) {
        var JsonResponse = eval(response);
        if (JsonResponse.StType === 'true') {
            //$('#msg-return').addClass('sucesso');
            setTimeout(function() {
                top.location.reload();
            }, 200);
        } else {
            $('#msg-return').addClass('erro');
        }
        $('#msg-return').html(JsonResponse.StMsg);
    }
}

var login = {
    'setEvents': function() {
        $('#button-login').click(function() {
            if (login.validaDados()) {
                login.executarLogin();
            }
        });
    },
    'validaDados': function() {
        if ($('#email').val() == '') {
            $('#msg-return').addClass('erro');
            $('#msg-return').html('Informe o email.');
            $('#email').focus();
            return false;
        }
        else if ($('#senha').val() == '') {
            $('#msg-return').addClass('erro');
            $('#msg-return').html('Informe a senha.');
            $('#senha').focus();
            return false;
        }
        else {
            $('#msg-return').removeClass('erro');
            $('#msg-return').html('');
            return true;
        }

    },
    'executarLogin': function() {
        var StEmail = $('#email').val();
        var StSenha = $('#senha').val();
        var StData = 'ArUsuario[StEmail]=' + StEmail + '&ArUsuario[StSenha]=' + StSenha;
        request.sendRequest('post', cache.url + 'login/xhrAutenticar', StData, login.loginCallBack);
    },
    'loginCallBack': function(response) {
        var JsonResponse = eval(response);
        if (JsonResponse.StType === 'true') {
            $('#msg-return').addClass('sucesso');
            //setTimeout(function() {top.location.reload();}, 4000);
            top.location.reload();
        } else {
            $('#msg-return').addClass('erro');
            $('#msg-return').html(JsonResponse.StMsg);
        }
    }

}

var avaliar = {
    'setEvents': function() {
        $('#box-avaliacao .stars li').click(function() {
            var $this = $(this);
            var ol = $this.parent('ol');
            var rating = $this.index() + 1;
            
            if ($this.hasClass('active') && !$this.next('li').hasClass('active')) {
                $(ol).find('li').removeClass('active');
                rating = 0;
            }
            else {
                $(ol).find('li').removeClass('active');
                for (var i = 0; i < rating; i++) {
                    $(ol).find('li').eq(i).addClass('active');
                }
            }
            ol.parent('div').find("input").val(rating);
        });
    }
}

var request = {
    'sendRequest'
            : function(StType, StUrl, StData, tSuccess) {
                $.ajax({
                    type: StType,
                    url: StUrl,
                    data: StData,
                    success: tSuccess,
                    beforeSend: function() {
                    },
                    error: function(request, status, errorThrown) {
                        var tReturn = {
                            message: 'Erro interno de requisi&ccedil;&atilde;o, recarregue ou tente novamente. Codigo do Erro: ' + status
                        };
                    }
                });
            },
    'showLoading'
            : function() {
                $('#loading-request').css('display', 'inline');
            },
    'hideLoading': function() {
        $('#loading-request').css('display', 'none');
    }
}