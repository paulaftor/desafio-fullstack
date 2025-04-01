<template>
    <div class="register-container">
      <div class="modal-content">
        <div class="title">Cadastro</div>
        <form @submit.prevent="register">
          
          <!-- Dados Pessoais -->
          <fieldset>
            <legend>Dados pessoais</legend>
            <div class="form-row">
              <div class="input-container" :class="{'error': errors.nome}">
                <label for="nome">Nome</label>
                <input type="text" id="nome" v-model="nome" placeholder="Digite seu nome" @blur="validateNome" />
                <span v-if="errors.nome" class="error-message">{{ errors.nome }}</span>
              </div>
              <div class="input-container" :class="{'error': errors.cpf}">
                <label for="cpf">CPF</label>
                <input type="text" id="cpf" v-model="cpf" v-mask="'###.###.###-##'" placeholder="Digite seu CPF" @blur="validateCpf" />
                <span v-if="errors.cpf" class="error-message">{{ errors.cpf }}</span>
              </div>
            </div>
  
            <div class="form-row">
              <div class="input-container" :class="{'error': errors.data_nascimento}">
                <label for="data_nascimento">Data de Nascimento</label>
                <input type="text" id="data_nascimento" v-model="data_nascimento" v-mask="'##/##/####'" placeholder="dd/mm/yyyy" @blur="validateDataNascimento" />
                <span v-if="errors.data_nascimento" class="error-message">{{ errors.data_nascimento }}</span>
              </div>
              <!-- Parentesco -->
              <div class="input-container">
                <label for="parentesco">Parentesco</label>
                <select id="parentesco" v-model="parentesco">
                  <option value="">Selecione o parentesco</option>
                  <option value="pai">Pai</option>
                  <option value="mae">Mãe</option>
                  <option value="irmao">Irmão</option>
                  <option value="irma">Irmã</option>
                  <option value="outro">Outro</option>
                </select>
              </div>
            </div>
          </fieldset>
          
          <!-- Dados de Contato -->
          <fieldset>
            <legend>Dados de contato</legend>
            <div class="form-row">
              <div class="input-container" :class="{'error': errors.telefone}">
                <label for="telefone">Telefone principal</label>
                <input type="text" id="telefone" v-model="telefone" v-mask="'(##) ####-####'" placeholder="Digite seu telefone" @blur="validateTelefone" />
                <span v-if="errors.telefone" class="error-message">{{ errors.telefone }}</span>
              </div>
              <div class="input-container">
                <label for="telefone2">Telefone secundário</label>
                <input type="text" id="telefone2" v-model="telefone2" v-mask="'(##) ####-####'" placeholder="Digite seu telefone" @blur="validateTelefone2" />
              </div>
            </div>
  
            <div class="form-row">
              <div class="input-container" :class="{'error': errors.email}">
                <label for="email">E-mail principal</label>
                <input type="email" id="email" v-model="email" placeholder="Digite seu e-mail" @blur="validateEmail" />
                <span v-if="errors.email" class="error-message">{{ errors.email }}</span>
              </div>
              <div class="input-container">
                <label for="email2">E-mail secundário</label>
                <input type="email" id="email2" v-model="email2" placeholder="Digite seu e-mail" @blur="validateEmail2" />
              </div>
            </div>
  
            <div class="form-row">
              <div class="input-container" :class="{'error': errors.senha}">
                <label for="senha">Senha</label>
                <input type="password" id="senha" v-model="senha" placeholder="Digite sua senha" @blur="validateSenha" />
                <span v-if="errors.senha" class="error-message">{{ errors.senha }}</span>
              </div>
              <div class="input-container" :class="{'error': errors.senha_confirmacao}">
                <label for="senha_confirmacao">Confirme sua senha</label>
                <input type="password" id="senha_confirmacao" v-model="senha_confirmacao" placeholder="Confirme sua senha" @blur="validateSenhaConfirmacao" />
                <span v-if="errors.senha_confirmacao" class="error-message">{{ errors.senha_confirmacao }}</span>
              </div>
            </div>
          </fieldset>
          
          <!-- Endereço -->
          <fieldset>
            <legend>Endereço</legend>
            <div class="form-row">
              <div class="input-container" :class="{'error': errors.cep}">
                <label for="cep">CEP</label>
                <input type="text" id="cep" v-model="cep" v-mask="'#####-###'" placeholder="Digite seu CEP" @blur="validateCep" />
                <span v-if="errors.cep" class="error-message">{{ errors.cep }}</span>
              </div>
              <div class="input-container">
                <label for="estado">Estado</label>
                <select id="estado" v-model="estado">
                  <option value="">Selecione o estado</option>
                  <option value="AC">AC</option>
                  <option value="AL">AL</option>
                  <option value="AP">AP</option>
                  <option value="AM">AM</option>
                  <option value="BA">BA</option>
                  <option value="CE">CE</option>
                  <option value="DF">DF</option>
                  <option value="ES">ES</option>
                  <option value="GO">GO</option>
                  <option value="MA">MA</option>
                  <option value="MT">MT</option>
                  <option value="MS">MS</option>
                  <option value="MG">MG</option>
                  <option value="PA">PA</option>
                  <option value="PB">PB</option>
                  <option value="PR">PR</option>
                  <option value="PE">PE</option>
                  <option value="PI">PI</option>
                  <option value="RJ">RJ</option>
                  <option value="RN">RN</option>
                  <option value="RS">RS</option>
                  <option value="RO">RO</option>
                  <option value="RR">RR</option>
                  <option value="SC">SC</option>
                  <option value="SP">SP</option>
                  <option value="SE">SE</option>
                  <option value="TO">TO</option>
                </select>
              </div>
              <div class="input-container">
                <label for="cidade">Cidade</label>
                <input type="text" id="cidade" v-model="cidade" placeholder="Digite sua cidade" />
              </div>
            </div>
            <div class="form-row">
              <div class="input-container">
                <label for="bairro">Bairro</label>
                <input type="text" id="bairro" v-model="bairro" placeholder="Bairro" />
              </div>
              <div class="input-container">
                <label for="logradouro">Logradouro</label>
                <input type="text" id="logradouro" v-model="logradouro" placeholder="Logradouro" />
              </div>
              <div class="input-container numero">
                <label for="numero">Número</label>
                <input type="text" id="numero" v-model="numero" placeholder="Número" />
                <span v-if="errors.numero" class="error-message">{{ errors.numero }}</span>
              </div>
            </div>
          </fieldset>
          
          <!-- Botão Cadastrar -->
          <button type="submit" class="btn-primary">Cadastrar</button>
        </form>
  
        <!-- Link para Login -->
        <div class="login-link-container">
          <p>Já tem uma conta? <a href="#" @click="$router.push('/')">Faça Login</a></p>
        </div>
      </div>
    </div>
  </template>
  
  
  <script>
  export default {
    data() {
      return {
        nome: "",
        cpf: "",
        data_nascimento: "",
        telefone: "",
        telefone2: "",
        email: "",
        email2: "",
        senha: "",
        senha_confirmacao: "",
        cep: "",
        logradouro: "",
        numero: "",
        bairro: "",
        cidade: "",
        estado: "",
        parentesco: "",
        errors: {},
        haErros: false // Variável para controlar se há erros
      };
    },
    methods: {
      validateNome() {
        if (!this.nome?.trim()) {
          this.errors.nome = "Nome é obrigatório";
          this.haErros = true;
        } else {
          this.errors.nome = "";
        }
      },
  
      validateNumero() {
        if (!this.numero?.trim()) {
          this.errors.numero = "Número é obrigatório";
          this.haErros = true;
        } else {
          this.errors.numero = "";
        }
      },
  
      validateCpf() {
        const cpfRegex = /^\d{3}\.\d{3}\.\d{3}-\d{2}$/;
        if (!this.cpf?.trim()) {
          this.errors.cpf = "CPF é obrigatório";
          this.haErros = true;
        } else {
          this.errors.cpf = cpfRegex.test(this.cpf) ? "" : "CPF inválido (formato: XXX.XXX.XXX-XX)";
          if (this.errors.cpf) this.haErros = true;
        }
      },
  
      validateDataNascimento() {
        const dataNascimentoRegex = /^\d{2}\/\d{2}\/\d{4}$/;
        if (!this.data_nascimento?.trim()) {
          this.errors.data_nascimento = "Data de nascimento é obrigatória";
          this.haErros = true;
        } else {
          this.errors.data_nascimento = dataNascimentoRegex.test(this.data_nascimento) ? "" : "Data de nascimento inválida (formato: dd/mm/yyyy)";
          if (this.errors.data_nascimento) this.haErros = true;
        }
      },
  
      validateTelefone() {
        const telefoneRegex = /^\(\d{2}\)\s\d{4,5}-\d{4}$/;
        if (!this.telefone?.trim()) {
          this.errors.telefone = "Telefone é obrigatório";
          this.haErros = true;
        } else {
          this.errors.telefone = telefoneRegex.test(this.telefone) ? "" : "Telefone inválido (formato: (XX) XXXX-XXXX)";
          if (this.errors.telefone) this.haErros = true;
        }
      },
  
      validateTelefone2() {
        if (this.telefone2?.trim() && !/^\(\d{2}\)\s\d{4,5}-\d{4}$/.test(this.telefone2)) {
          this.errors.telefone2 = "Telefone secundário inválido";
          this.haErros = true;
        } else {
          this.errors.telefone2 = "";
        }
      },
  
      validateEmail() {
        const emailRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
        if (!this.email?.trim()) {
          this.errors.email = "E-mail é obrigatório";
          this.haErros = true;
        } else {
          this.errors.email = emailRegex.test(this.email) ? "" : "E-mail inválido";
          if (this.errors.email) this.haErros = true;
        }
      },
  
      validateEmail2() {
        if (this.email2?.trim() && !/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/.test(this.email2)) {
          this.errors.email2 = "E-mail secundário inválido";
          this.haErros = true;
        } else {
          this.errors.email2 = "";
        }
      },
  
      validateSenha() {
        if (!this.senha?.trim()) {
          this.errors.senha = "Senha é obrigatória";
          this.haErros = true;
        } else {
          this.errors.senha = "";
        }
      },
  
      validateSenhaConfirmacao() {
        if (this.senha !== this.senha_confirmacao) {
          this.errors.senha_confirmacao = "Senhas não coincidem";
          this.haErros = true;
        } else {
          this.errors.senha_confirmacao = "";
        }
      },
  
      validateCep() {
        const cepRegex = /^\d{5}-\d{3}$/;
        if (!this.cep?.trim()) {
          this.errors.cep = "CEP é obrigatório";
          this.haErros = true;
        } else {
          this.errors.cep = cepRegex.test(this.cep) ? "" : "CEP inválido (formato: XXXXX-XXX)";
          if (this.errors.cep) this.haErros = true;
          else {
            const cepSemHifen = this.cep.replace("-", "");
            this.buscarEndereco(cepSemHifen);
          }
        }
      },
  
      buscarEndereco(cep) {
        fetch(`https://viacep.com.br/ws/${cep}/json/`)
          .then(response => response.json())
          .then(data => {
            if (data.erro) {
              this.errors.cep = "CEP não encontrado";
              this.haErros = true;
            } else {
              this.logradouro = data.logradouro;
              this.bairro = data.bairro;
              this.cidade = data.localidade;
              this.estado = data.uf;
            }
          })
          .catch(() => {
            this.errors.cep = "Erro ao buscar o CEP";
            this.haErros = true;
          });
      },
  
      removeFormatacao(valor) {
        return valor.replace(/\D/g, ""); // Remove todos os caracteres não numéricos
      },
  
      formatarDataParaISO(data) {
        if (!data) return null;
        const [dia, mes, ano] = data.split('/');
        return `${ano}-${mes}-${dia}`; // Formato YYYY-MM-DD
      },
  
      async register() {
        console.log("register chamado");
        // Limpar erros antes de validar
        this.errors = {};
        this.haErros = false;  // Resetar o valor para false
  
        // Validar todos os campos
        this.validateNome();
        this.validateNumero();
        this.validateCpf();
        this.validateDataNascimento();
        this.validateTelefone();
        this.validateTelefone2();
        this.validateEmail();
        this.validateEmail2();
        this.validateSenha();
        this.validateSenhaConfirmacao();
        this.validateCep();
  
        // Verificar se há erros
        if (!this.haErros) {
          try {
            const userData = {
              nome: this.nome,
              cpf: this.removeFormatacao(this.cpf),
              data_nascimento: this.formatarDataParaISO(this.data_nascimento),
              telefone: this.removeFormatacao(this.telefone),
              telefone2: this.removeFormatacao(this.telefone2),
              email: this.email,
              email2: this.email2,
              senha: this.senha,
              senha_confirmation: this.senha_confirmacao,
              cep: this.removeFormatacao(this.cep),
              logradouro: this.logradouro,
              numero: this.numero,
              bairro: this.bairro,
              cidade: this.cidade,
              estado: this.estado,
              parentesco: this.parentesco
            };
  
            console.log("Dados enviados:", userData); // Para depuração
  
            const response = await fetch("http://localhost:8000/api/users", {
              method: "POST",
              headers: {
                "Content-Type": "application/json",
                "Accept": "application/json",
              },
              body: JSON.stringify(userData),
            });
  
            const responseData = await response.json();
            console.log("Resposta da API:", responseData);
  
            if (response.ok) {
              alert("Usuário cadastrado com sucesso!");
              this.$router.push("/usuarios"); // Redirecionar para a página de usuários
            } else {
              this.errors = responseData.erros || {};
              this.haErros = true;
            }
          } catch (error) {
            console.error("Erro ao cadastrar usuário:", error);
            this.errors = { geral: "Erro ao cadastrar usuário" };
            this.haErros = true;
          }
        }
      }
    }
  };
  </script>
  
  <style scoped>
  
  .modal-content {
    background-color: #fff;
    padding: 2rem;
    border-radius: 8px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    width: 100%;
    max-width: 80%;
    overflow-y: auto; 
  }
  
  fieldset {
    border: none;
    border-left: 1px solid #ccc;
    padding: 1rem;
    border-radius: 5px;
    margin-bottom: 1rem;
  }
  
  legend {
    font-weight: bold;
    color: gray;
  }
  
  .form-row {
    display: flex;
    flex-wrap: wrap;
    gap: 15px;
  }
  
  .input-container {
    flex: 1;
    min-width: 200px;
  }
  
  select {
    width: 100%;
    padding: 0.75rem;
    margin-top: 0.25rem;
    border: 1px solid #ccc;
    border-radius: 5px;
    background-color:transparent;
    color: gray;
  }
  
  select:focus {
    border-color: #4447ed;
    outline: none;
  }
  
  .btn-primary {
    background-color: #4447ed;
    color: #fff;
    padding: 1rem;
    border: none;
    border-radius: 5px;
    width: 30%;
    cursor: pointer;
  }
  
  @media (max-width: 768px) {
    .form-row {
      flex-direction: column;
    }
  }
  
  /* Para campos com erro, aplicamos a classe .error diretamente no input */
  .input-container input.error {
    border-color: red;  /* A borda vermelha */
  }
  
  /* Mensagem de erro */
  .error-message {
    color: red;
    font-size: 12px;
    margin-top: 5px;
  }
  
  </style>
  