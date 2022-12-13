const nature_glamour_pages = {};
const base_url = "http://127.0.0.1:8000/api/v0.1/glamour/";

nature_glamour_pages.Console = (title, values, oneValue = true) => {
  console.log("---" + title + "---");
  if (oneValue) {
    console.log(values);
  } else {
    for (let i = 0; i < values.length; i++) {
      console.log(values[i]);
    }
  }
  console.log("--/" + title + "---");
};

nature_glamour_pages.loadFor = (page) => {
  eval("nature_glamour_pages.load_" + page + "();");
};
nature_glamour_pages.postAPI = async (api_url, api_data, api_token = null) => {
  try {
    return await axios.post(api_url, api_data, {
      headers: {
        Authorization: "token " + api_token,
        // "Content-Type": "multipart/form-data boundary=something",
      },
    });
  } catch (error) {
    nature_glamour_pages.Console("Error from Linking (POST)", error);
  }
};
nature_glamour_pages.getAPI = async (api_url) => {
  try {
    return await axios(api_url);
  } catch (error) {
    nature_glamour_pages.Console("Error from Linking (GET)", error);
  }
};
nature_glamour_pages.load_register = () => {
  const signup_btn = document.getElementById("register");
  const result = document.getElementById("response");

  const responseHandler = () => {
    result.innerHTML = `<main id = "response" class="container mt-3">`;
  };

  const signup = async () => {
    const signup_url = base_url + "signup";

    const signup_data = new URLSearchParams();
    signup_data.append("username", document.getElementById("username").value);
    signup_data.append("email", document.getElementById("email").value);
    signup_data.append("password", document.getElementById("password").value);

    const response = await nature_glamour_pages.postAPI(
      signup_url,
      signup_data
    );
    if (response.data.status == "error") {
      result.innerHTML = `<main id = "response" class="container mt-3">
        <div class="alert alert-danger alert-dismissible fade show" role="alert">${response.data.results}
      </div></main>`;
      setTimeout(responseHandler, 2000);
    }
    if (response.data.status == "success") {
      result.innerHTML = `<main id = "response" class="container mt-3">
        <div class="alert alert-success alert-dismissible fade show" role="alert">${response.data.results}
      </div></main>`;
      setTimeout(responseHandler, 2000);
      // Switching to the stream page
      window.location.href = "login.html";
    }
  };
  signup_btn.addEventListener("click", signup);
};
