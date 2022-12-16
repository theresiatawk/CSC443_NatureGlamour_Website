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
<<<<<<< HEAD
=======
nature_glamour_pages.securePostAPI = async (api_url, api_data, api_token) => {
  try {
    return await axios.post(api_url, api_data, {
      headers: {
        Authorization: "Bearer " + api_token,
      },
    });
  } catch (error) {
    nature_glamour_pages.Console("Error from Linking (POST)", error);
  }
};
>>>>>>> frontend
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
<<<<<<< HEAD
=======
  const icon = document.getElementById("icon");
>>>>>>> frontend

  const responseHandler = () => {
    result.innerHTML = `<main id = "response" class="container mt-3">`;
  };
<<<<<<< HEAD
=======
  const iconHandler = () => {
    const nav = document.getElementById("myTopnav");
    if (nav.className === "topnav") {
      nav.className += " responsive";
    } else {
      nav.className = "topnav";
    }
  };
>>>>>>> frontend

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
<<<<<<< HEAD
      result.innerHTML = `<main id = "response" class="container mt-3">
=======
      result.innerHTML = `<main id = "response" class="container response">
>>>>>>> frontend
        <div class="alert alert-danger alert-dismissible fade show" role="alert">${response.data.results}
      </div></main>`;
      setTimeout(responseHandler, 2000);
    }
    if (response.data.status == "success") {
<<<<<<< HEAD
      result.innerHTML = `<main id = "response" class="container mt-3">
=======
      result.innerHTML = `<main id = "response" class="container response">
>>>>>>> frontend
        <div class="alert alert-success alert-dismissible fade show" role="alert">${response.data.results}
      </div></main>`;
      setTimeout(responseHandler, 2000);
      // Switching to the stream page
      setTimeout(function () {
        window.location.href = "login.html";
      }, 2000);
    }
  };
  signup_btn.addEventListener("click", signup);
<<<<<<< HEAD
=======
  icon.addEventListener("click", iconHandler);
>>>>>>> frontend
};
nature_glamour_pages.load_login = () => {
  const login_btn = document.getElementById("login");
  const result = document.getElementById("response");
<<<<<<< HEAD
=======
  const icon = document.getElementById("icon");
>>>>>>> frontend

  const responseHandler = () => {
    result.innerHTML = `<main id = "response" class="container mt-3">`;
  };
<<<<<<< HEAD
  const login = async () => {
    const login_url = base_url + "login";

=======
  const iconHandler = () => {
    const nav = document.getElementById("myTopnav");
    if (nav.className === "topnav") {
      nav.className += " responsive";
    } else {
      nav.className = "topnav";
    }
  };
  const login = async () => {
    const login_url = base_url + "login";
>>>>>>> frontend
    const login_data = new URLSearchParams();
    login_data.append("email", document.getElementById("email").value);
    login_data.append("password", document.getElementById("password").value);

    const response = await nature_glamour_pages.postAPI(login_url, login_data);
<<<<<<< HEAD
    console.log(response);
=======
>>>>>>> frontend
    if (response.data.status == "error") {
      result.innerHTML = `<main id = "response" class="container mt-3">
          <div class="alert alert-danger alert-dismissible fade show" role="alert">${response.data.results}
        </div></main>`;
      setTimeout(responseHandler, 2000);
    }
    if (response.data.status == "success") {
<<<<<<< HEAD
=======
      const userData = [];
      const user_id = response.data.user.id;
      const username = response.data.user.username;
      const user_email = response.data.user.email;
      const access_token = response.data.authorisation.token;
      userData.push({ user_id, username, user_email, access_token });
      localStorage.setItem("userData", JSON.stringify(userData));
>>>>>>> frontend
      result.innerHTML = `<main id = "response" class="container mt-3">
          <div class="alert alert-success alert-dismissible fade show" role="alert">${response.data.results}
        </div></main>`;
      setTimeout(responseHandler, 2000);
<<<<<<< HEAD
=======
      console.log(access_token);
>>>>>>> frontend
      // Switching to the stream page
      setTimeout(function () {
        window.location.href = "gallery.html";
      }, 2000);
    }
  };
  login_btn.addEventListener("click", login);
<<<<<<< HEAD
=======
  icon.addEventListener("click", iconHandler);
};
nature_glamour_pages.load_gallery = () => {
  const result = document.getElementById("response");
  const getSpots = async () => {
    const get_spots_url = base_url + "posts";
    const response = await nature_glamour_pages.getAPI(get_spots_url);
    const all_spots = document.getElementById("allSpots");
    let spots_list = `<div id = "allSpots">`;
    if (response.data.status == "error") {
      result.innerHTML = `<main id = "response" class="container mt-3">
          <div class="alert alert-success alert-dismissible fade show" role="alert">No Spots
        </div></main>`;
    }
    if (response.data.status == "success") {
      const spots = response.data.posts;
      const likes = response.data.likes;
      spots.map(
        (spot, i) =>
          (spots_list += `<div id = ${spot.id} class="container">
        <div class="card">
          <div class="row">
            <div class="col-md-4">
                <img class="img-fluid" alt=""
                    src="../../Backend/storage/app/public/posts/${spot.url}">
            </div>
            <div class="col-md-8">
              <div class="card-body">
                <h5 class="card-title">${spot.username}</h5>
                <p class="card-text"></p>
                <p class="card-text">
                  <small class="text-muted">location</small>
                </p>
                <div id = ${spot.id} class="flex-row">
                  <img class="heart-img" src="../Utils/empty_heart.png">
                  <p class="like-text">
                  ${
                    likes.findIndex((element) => element.post_id == spot.id) !=
                    -1
                      ? likes[
                          likes.findIndex(
                            (element) => element.post_id == spot.id
                          )
                        ].likes_count
                      : 0
                  }</p>
                </div>
                <a id = ${spot.id} href = "./reviews.html?spot=${
            spot.id
          }" class="btn Review">+Review</a>
              </div>
            </div>
          </div>
        </div>
      </div>`)
      );
      spots_list += `</div>`;
      all_spots.innerHTML = spots_list;
    }
  };
  const getIcons = async () => {
    const result = await getSpots();
    const user = JSON.parse(localStorage.getItem("userData"));
    const user_id = user[0].user_id;
    const like_icons = document.querySelectorAll(".heart-img");
    like_icons.forEach(async (element) => {
      console.log(element);
      console.log(element.getAttribute('src'));
      const spot_id = element.parentElement.id;
      const check_like_url = base_url + "likes/check/"+ user_id + "/"+ spot_id;
      const response = await nature_glamour_pages.getAPI(check_like_url);
      element.src.value = "../Utils/full_heart.png";
      if(response.data.results == "true"){
        element.src = "../Utils/full_heart.png";
      }

    });
    return like_icons;
  };
  const likeSpotHandler = async (e) => {
    const spot_id = e.target.parentElement.id;
    const user = JSON.parse(localStorage.getItem("userData"));
    const user_id = user[0].user_id;
    const token = user[0].access_token;
    const like_spot_url = base_url + "likes/add";
    const delete_like_url = base_url + "likes/delete";
    const like_data = new URLSearchParams();
    like_data.append("post_id", spot_id);
    like_data.append("user_id", user_id);

    if (e.srcElement.attributes[1].value == "../Utils/full_heart.png") {
      e.srcElement.attributes[1].value = "../Utils/empty_heart.png";
      const response = await nature_glamour_pages.securePostAPI(
        delete_like_url,
        like_data,
        token
      );
    } else {
      e.srcElement.attributes[1].value = "../Utils/full_heart.png";
      const response = await nature_glamour_pages.securePostAPI(
        like_spot_url,
        like_data,
        token
      );
    }
  };
  const listen = async () => {
    const like_icons = await getIcons();
    like_icons.forEach((b) => b.addEventListener("click", likeSpotHandler));
  };
  listen();
};
nature_glamour_pages.load_reviews = () => {
  const result = document.getElementById("response");
  const add_review = document.getElementById("addReview");
  const getUrlVars = () => {
    const vars = {};
    const parts = window.location.href.replace(
      /[?&]+([^=&]+)=([^&]*)/gi,
      function (m, key, value) {
        vars[key] = value;
      }
    );
    return vars;
  };
  const responseHandler = () => {
    result.innerHTML = `<main id = "response" class="container mt-3">`;
  };
  const clicked_spot_id = getUrlVars()["spot"];

  const getReviews = async () => {
    const get_reviews_url = base_url + "comments/" + clicked_spot_id;
    const response = await nature_glamour_pages.getAPI(get_reviews_url);
    const all_reviews = document.getElementById("allReviews");
    let reviews_list = `<div id = "allReviews">`;
    if (response.data.status == "error") {
      result.innerHTML = `<main id = "response" class="container mt-3">
          <div class="alert alert-success alert-dismissible fade show" role="alert">No Reviews
        </div></main>`;
    }
    if (response.data.status == "success") {
      const reviews = response.data.comments;
      reviews.map(
        (review, i) =>
          (reviews_list += `<div class="card margin-bttm">
            <div class="card-body">
              <h5 class="card-title">${review.username}</h5>
              <p class="card-text">${review.comment}</p>
            </div>
          </div>`)
      );
    }
    reviews_list += `</div>`;
    all_reviews.innerHTML = reviews_list;
  };
  const addReview = async () => {
    const add_review_url = base_url + "comments/add";
    const review_data = new URLSearchParams();
    const user = JSON.parse(localStorage.getItem("userData"));
    const user_id = user[0].user_id;
    const token = user[0].access_token;
    review_data.append("post_id", clicked_spot_id);
    review_data.append("user_id", user_id);
    review_data.append("comment", document.getElementById("reviewBody").value);

    const response = await nature_glamour_pages.securePostAPI(
      add_review_url,
      review_data,
      token
    );
    if (response.data.status == "error") {
      result.innerHTML = `<main id = "response" class="container response">
        <div class="alert alert-danger alert-dismissible fade show" role="alert">${response.data.results}
      </div></main>`;
      setTimeout(responseHandler, 2000);
    }
    if (response.data.status == "success") {
      result.innerHTML = `<main id = "response" class="container response">
        <div class="alert alert-success alert-dismissible fade show" role="alert">${response.data.results}
      </div></main>`;
      setTimeout(responseHandler, 2000);
    }
  };
  getReviews();
  add_review.addEventListener("click", addReview);
};
nature_glamour_pages.load_add_spot = () => {
  const result = document.getElementById("response");
  const add_post = document.getElementById("add-spot");
  const responseHandler = () => {
    result.innerHTML = `<main id = "response" class="container mt-3">`;
  };
  const addSpot = async () => {
    const add_spot_url = base_url + "posts/add";
    const spot_data = new URLSearchParams();
    spot_data.append("username", document.getElementById("username").value);
    spot_data.append("email", document.getElementById("email").value);
    spot_data.append("password", document.getElementById("password").value);

    const response = await nature_glamour_pages.postAPI(
      add_spot_url,
      spot_data
    );
  };
  add_post.addEventListener("click", addSpot);
>>>>>>> frontend
};
