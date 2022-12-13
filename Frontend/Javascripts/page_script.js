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
instagram_like_pages.postAPI = async (api_url, api_data, api_token = null) => {
  try {
    return await axios.post(api_url, api_data, {
      headers: {
        Authorization: "token " + api_token,
        // "Content-Type": "multipart/form-data boundary=something",
      },
    });
  } catch (error) {
    instagram_like_pages.Console("Error from Linking (POST)", error);
  }
};
instagram_like_pages.getAPI = async (api_url) => {
  try {
    return await axios(api_url);
  } catch (error) {
    instagram_like_pages.Console("Error from Linking (GET)", error);
  }
};
