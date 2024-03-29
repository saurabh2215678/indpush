import React from 'react';
import './App.css';
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
import ForgotPassword from './Pages/ForgotPassword.js';
import ResetPassword from './Pages/ResetPassword.js';
import ProfileUpadate from './Pages/ProfileUpadate.js';
import Setting from './Pages/Setting.js';
import DownloadPlugin from './Pages/DownloadPlugin.js';
import MasterAdmin from './Pages/MasterAdmin.js';

function App() {

  return (
    <>
   <Provider store={store}>
    <UserAuth/>
    <Router>
      <Routes>

        <Route path="/login" element={ <Login />}/>
        <Route path="/signup" element={<Signup />}/>
        <Route path="/forgot-password" element={<ForgotPassword />}/>
        <Route path="/reset-password/*" element={<ResetPassword />}/>
        <Route element={<WebsiteLayout/>}>
          <Route path="/" element={<Home />}/>
          <Route path="*" element={<PageNotFound />} />
        </Route>
        <Route element={<UserLayout />}>
          <Route path="/dashboard" element={<Dashboard />}/>
          <Route path="/verify-account" element={<VerifyAccount />}/>
          <Route path="/update-profile" element={<ProfileUpadate />}/>
          <Route path="/setting" element={<Setting />}/>
          <Route path="/download" element={<DownloadPlugin />}/>
          <Route path="/master-admin" element={<MasterAdmin />}/>
        </Route>
   
      </Routes>
    </Router>
    </Provider>
    <ToastContainer />
    </>
  );
}

export default App;
