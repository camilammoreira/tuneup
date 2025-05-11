# Controle de Estoque do Setor de TI 🖥️📦

Um sistema desenvolvido em PHP para gerenciar o controle de estoque de materiais do setor de Tecnologia da Informação (TI) de uma escola, como parte do **Projeto Integrador** do curso técnico em informática.

## 🛠 Funcionalidades

- Cadastro de equipamentos e materiais de informática.
- Controle de entrada e saída de itens.
- Geração de relatórios sobre o estoque. (em desenvolvimento)
- Interface intuitiva e responsiva com HTML, CSS e JavaScript.
- Sistema de autenticação para segurança.

## ⚙️ Tecnologias Utilizadas

- **Backend**: PHP
- **Frontend**: HTML5, CSS3, JavaScript
- **Banco de Dados**: MySQL
- **Frameworks**: Bootstrap (para estilização), jQuery (para interatividade)
- **Servidor Local**: XAMPP ou WAMP

## 📂 Estrutura do Projeto

controle-estoque/ ├── cod/ # Código principal do projeto │ ├── css/ # Arquivos de estilo │ ├── js/ # Scripts JavaScript │ ├── imagens/ # Imagens do projeto │ ├── header.php # Cabeçalho do site │ ├── footer.php # Rodapé do site ├── index.php # Página inicial ├── conexao.php # Configuração do banco de dados ├── README.md # Documentação do projeto

## 🚀 Como Executar o Projeto

### Pré-requisitos
1. Servidor local como XAMPP ou WAMP instalado no seu computador.
2. Banco de dados MySQL configurado.

### Configuração
1. Clone o repositório para sua máquina local:
   ```bash
   git clone https://github.com/camilammoreira/tuneup.git
2. Coloque a pasta do projeto na pasta htdocs (para XAMPP) ou equivalente.
3. Configure o banco de dados:
- Crie um banco de dados no phpMyAdmin chamado tuneup (ou outro nome).
- Importe o arquivo .sql fornecido no repositório para criar as tabelas.
- Atualize as credenciais do banco de dados no arquivo cod/bdconfig.php:
    ```bash
    $bd_host = 'localhost';
    $bd_banco   = 'tuneup';
    $bd_usu = 'root';
    $bd_senha = '';
4. Executando o Projeto
- Inicie o Apache e o MySQL no XAMPP/WAMP.
- Acesse o projeto no navegador: http://localhost/tuneup/


## 📜 Histórico do Projeto
Este sistema foi desenvolvido em 2018 como parte do Projeto Integrador do curso técnico em informática, com o objetivo de otimizar o gerenciamento de materiais de TI da escola. O projeto envolveu o uso de tecnologias web modernas para criar uma solução prática e funcional.

## 📝 Licença
Este projeto é de uso livre para fins educacionais e experimentais.

## 📌 Observações
Certifique-se de ajustar os caminhos no header.php e footer.php para o correto funcionamento dos recursos estáticos (CSS, JS, imagens).
Contribuições são bem-vindas! Abra um PR ou envie sugestões na aba Issues.

## Pôster apresentado como Projeto Integrador

![Poster](https://github.com/camilammoreira/tuneup/blob/main/img/Poster-PI-2018-min.png)

Desenvolvido com 💻 e ☕ por <a href="https://github.com/camilammoreira">Camila Moreira</a> e Levy Amorim.
