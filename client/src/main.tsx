import React from "react";
import ReactDOM from "react-dom";
import App from "./App";
import "./index.css";
import { HashRouter } from "react-router-dom";
import { Provider } from "react-redux";
import store from "../src/Store/store";

ReactDOM.render(
  <HashRouter>
    <Provider store={store}>
      <App />
    </Provider>
  </HashRouter>,
  document.getElementById("root")
);
