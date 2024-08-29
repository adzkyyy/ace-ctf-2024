FROM debian:bullseye-slim

RUN apt-get update && \
    apt-get install -y \
    python3-pip socat

RUN     useradd ctf
WORKDIR /home/ctf

COPY main.py      /home/ctf/
COPY requirements.txt /home/ctf/

RUN chown -R root:root  /home/ctf
RUN chmod -R 555        /home/ctf

RUN pip3 install -r requirements.txt

EXPOSE 20080
ENTRYPOINT ["socat", "TCP-LISTEN:20080,reuseaddr,fork,nodelay,su=ctf", "EXEC:'python3 main.py'"]