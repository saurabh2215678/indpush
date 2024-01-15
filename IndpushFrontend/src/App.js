import React from 'react';
import { BrowserRouter as Router, Route, Routes } from 'react-router-dom';
import Login from './Pages/Login.js';
import Signup from './Pages/Signup.js';
import Dashboard from './Pages/Dashboard.js';
import PageNotFound from './Pages/PageNotFound.js';
import UserLayout from './Layouts/UserLayout.js';
import WebsiteLayout from './Layouts/WebsiteLayout.js';
import {store} from './Redux/store.js';
import { Provider } from 'react-redux';
import { ToastContainer } from 'react-toastify';
import 'react-toastify/dist/ReactToastify.css';
import Home from './Pages/Home.js';
import VerifyAccount from './Pages/VerifyAccount.js';
import UserAuth from './Components/UserAuth.js';

function App() {

  return (
    <div>
   <Provider store={store}>
    <UserAuth/>
    <Router>
      <Routes>

        <Route path="/login" element={ <Login />}/>
        <Route path="/signup" element={<Signup />}/>
        <Route element={<WebsiteLayout/>}>
          <Route path="/" element={<Home />}/>
          <Route path="*" element={<PageNotFound />} />
        </Route>
        <Route element={<UserLayout />}>
          <Route path="/dashboard" element={<Dashboard />}/>
          <Route path="/verify-account" element={<VerifyAccount />}/>
        </Route>
   
      </Routes>
    </Router>
    </Provider>
    <ToastContainer />
    </div>
  );
}

export default App;
