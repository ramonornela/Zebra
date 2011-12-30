
----- INTRODUÇÃO ---------------------------------------------------------------

O manual é escrito em Docbook XML e requer um Sistema Operacional capaz de
transformar arquivos XML em outros formatos.

----- INSTALAÇÃO ---------------------------------------------------------------

                                                        UNIX / DEBIAN ----------

Abaixo estão listados os pacotes comum aos Sistemas Operacionais baseados no
Debian, caso o seu seja diferente, procure pacotes relativos.

    1. Instale os seguintes pacotes:
       $ apt-get install automake make libxml2-utils xsltproc fop
    2. Vá ao diretório raiz da documentação (onde este arquivo e os demais de
       extensão "in" estão localizados).
    3. Execute:
       $ autoconf
       $ ./configure

Durante a geração da documentação, o seguinte aviso pode aparecer: "unable to
locate servlet-api in /usr/share/java". Para retirar essa mensagem, execute:

   $ apt-get install libservlet2.5-java
   $ ln -s /usr/share/java/servlet-apt-2.5.jar /usr/share/java/servlet-apt.jar

Durante a geração da documentação, outra mensagem pode aparecer: "couldn't find
hyphenation pattern pt_br". Para resolver essa mensagem, siga os passos:

    1. Faça o download do pacote offo-hyphenation-fop-stable_v1.2.zip
       http://sourceforge.net/projects/offo/files/offo-hyphenation/1.2/

    2. No pacote baixadao terá um arquivo chamado "fop-hyph.jar". Mova-o para um
       local desejado.

    3. Antes de executar os passos da instalação instalação, execute:
       $ export FOP_HYPHENATION_PATH=/caminho/do/arquivo/fop-hyph.jar

                                                              WINDOWS ----------

No Windows, você consegue compilar o docbook utilizando o Cygwin. Veja:
http://www.cygwin.com

    1. Escolha "Instalar da Internet", pressione [Próximo]
    2. Escolha o diretório onde você quer instalar o Cygwin. Deixe as outras
       opções com valor "RECOMENDADO". Pressione [Próximo].
    3. Selecione um diretório onde você quer baixar os arquivos. Pressione
       [Próximo].
    4. Selecione seu meio de comunicação com a Internet. Pressione [Próximo].
    5. Escolha o melhor servidor da lista de espelhos para fazer o download.
       Pressione [Próximo].
    6. Selecione os seguintes pacotes de Devel ou Libs para instalar:
       * automake1.9
       * libxslt
       * make
       Todas as dependências serão automaticamente selecionadas para você.
       Pressione [Próximo].
    7. Sente e relaxe enquanto o Cygwin e os pacotes selecionados são baixados e
       instalados. Isso pode demorar.
    8. Marque a opção "Criar ícone na Área de Trabalho" e "Adicionar ícone no
       Menu Iniciar". Pressione [Finalizar].
    9. Abra o terminal, ou no Windows acione o Cygwin (você pode dar um duplo
       click no ícone na área de trabalho ou aciona o item de menu no Menu
       Iniciar.)
   10. Vá ao diretório raiz da documentação (onde este arquivo e os demais de
       extensão "in" estão localizados). Drivers são armazenados em "/cygdrive".

----- GERADORANDO A DOCUMENTAÇÃO -----------------------------------------------

                                                                 HTML ----------

    1. Vá ao diretório raiz da documentação (onde este arquivo e os demais de
       extensão "in" estão localizados).
    2. Execute:
       $ make html

                                                                 PDF -----------

    1. Vá ao diretório raiz da documentação (onde este arquivo e os demais de
       extensão "in" estão localizados).
    2. Execute:
       $ make pdf

----- RESOLVENDO PROBLEMAS -----------------------------------------------------

Se você encontrar erros durante tentativa de execução das instruções acima...

    1. Remove todos os arquivos do subdiretório html/, exceto o dbstyle.css
    2. Remova todos os arquivos do diretório atual, exceto: README.txt e os de
       extensão "in".
    3. Você pode opcionalmente remover os diretórios "/autom4te.cache"
    4. Tente construir a documentação seguindo as instruções fornecidas acima.
       Se o erro persistir, crie um ticket detalhando ao máximo o erro em:
       http://www.assembla.com/spaces/zebra/tickets
