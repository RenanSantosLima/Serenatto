<?php 

    class Produto {

        private ?int $id;
        private string $tipo;
        private string $nome;
        private string $descricao;
        private string $imagem;
        private float $preco;

        public function __construct(?int $id, string $tipo, string $nome, string $descricao, float $preco, string $imagem = "logo-serenatto.png")
        {
            $this->id = $id;
            $this->tipo = $tipo;
            $this->nome = $nome;
            $this->descricao = $descricao;
            $this->preco = $preco;
            $this->imagem = $imagem;
        }

        public function recuperarId(): int {
            return $this->id;
        }

        public function recuperarTipo(): string {
            return $this->tipo;
        }

        public function recuperarNome(): string {
            return $this->nome;
        }

        public function recuperarDescricao(): string {
            return $this->descricao;
        }

        public function recuperarImagem(): string {
            return $this->imagem;
        }

        public function setImagem(string $imagem) {
            $this->imagem = $imagem;
        }

        public function recuperarImagemDiratorio(): string {
            return "img/" . $this->imagem;
        }

        public function recuperarPreco(): float {
            return $this->preco;
        }

        public function recuperarPrecoFromatado(): string {
            return "R$" . number_format($this->preco, 2);
        }
    }

?>