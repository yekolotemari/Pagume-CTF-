from os import sendfile
from flask import Flask, json, jsonify, render_template,  request, redirect, send_file
import urllib.request
from urllib.parse import urlparse

app = Flask(__name__)


@app.route("/")
def index():
    return render_template('index.html')


@app.route("/login", methods=["POST"])
def post_login():
    username = request.form.get('username')
    password = request.form.get('password')

    # Check username and password (dummy check for demonstration)
    if username == 'admin' and password == 'password':
        # Successful login, redirect to dashboard
        return jsonify({"success": "true"}), 200
    else:
        # Failed login, return error response
        return 'Login failed', 401
    return render_template('login.html')

@app.route("/login")
def index_login():
    return render_template('login.html')



@app.route("/v2/dashboard")
def userDashboard():
    cookie = request.data

    return render_template('dashboard.html')

@app.route("/dashboard/name", methods=["post"])
def usergetbyname():
    name = request.form.get("k_name")
    result = "under maintenance" 
    kebeles = ["piyassa/10", "ledeta/21", "arada/11","saris/05"]
    if name in kebeles:
        name = name.replace("/", "_")
        return send_file(f"static/images/{name}.png")

    else:
        return jsonify({"error": "not found"}), 404


@app.route("/dashboard/url", methods=["POST"])
def userGetURL():
    url = request.form.get("k_url") 
    print("->>>>> ", url)
    block_schemes = ["file", "gopher", "expect", "php", "dict", "ftp", "glob", "data"]
    block_host = ["instagram.com", "youtube.com", "file", "burpcolaborator", ]
    input_scheme = urlparse(url).scheme
    input_hostname = urlparse(url).hostname
    print("->>>>> ", urlparse(url),  input_hostname)
    # if "www" in input_hostname: 
    #     input_hostname = input_hostname.split("www.")[-1]
    #     url = url.replace("www.", "")

    # if not input_hostname or not input_scheme: 
    #     return jsonify({"error": "Invalid hostname or scheme specified"}), 400
    if input_scheme in block_schemes:
        print("input scheme is forbidden")
        return jsonify({"error" : "Forbidden scheme"}), 400
    if input_hostname in block_host:
        return jsonify({"error" : "urlparse: Forbidden Hostname"}), 400

    try: 
        target = urllib.request.urlopen(url)
        content = target.read().decode('utf-8')  # Decode bytes to string

        # Return the content as a JSON response
        return jsonify({"data": content}), 200
    except Exception as e:
        return jsonify({"error" : f"urllib.error: {e}"}), 400


if __name__ == '__main__':
   app.run()
