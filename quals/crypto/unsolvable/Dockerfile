FROM sagemath/sagemath:latest

RUN sudo apt-get -y update --fix-missing
RUN sudo apt-get -y upgrade
RUN sudo apt-get install -y socat

COPY chall.sage chall.sage

CMD ["socat", "TCP-L:9999,fork,reuseaddr", "EXEC:'sage chall.sage'"]
