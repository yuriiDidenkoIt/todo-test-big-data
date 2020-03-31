import React from 'react';
import ReactDOM from 'react-dom'
import { Provider } from "react-redux";
import store from "./redux/store";
import TodoApp from "./components/TodoApp";
import '../css/app.css'

const rootElement = document.getElementById('app');

ReactDOM.render(
    <Provider store={store}>
        <TodoApp/>
    </Provider>,
    rootElement
);




