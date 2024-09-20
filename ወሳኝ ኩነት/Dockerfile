FROM python:3.8.10-alpine

WORKDIR /app
RUN mkdir -p /app

COPY .  .
COPY flag.txt /opt/flag.txt
RUN pip install -r requirements.txt 
EXPOSE 5000 
ENV FLASK_APP=app.py
CMD ["flask", "run", "--host", "0.0.0.0"]
