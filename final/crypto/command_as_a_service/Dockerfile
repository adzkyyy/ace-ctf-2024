FROM python:alpine

RUN apk add --no-cache socat
RUN pip install sympy pycryptodome
COPY auth.py /auth.py

CMD socat TCP-LISTEN:13337,fork,reuseaddr EXEC:"python3 server.py"
