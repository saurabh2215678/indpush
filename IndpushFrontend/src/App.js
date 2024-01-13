import React, { useEffect,useState } from 'react';
import { BrowserRouter as Router, Route, Routes } from 'react-router-dom';
import Login from './Pages/Login.js';
import Signup from './Pages/Signup.js';
import Dashboard from './Pages/Dashboard.js';
import PageNotFound from './Pages/PageNotFound.js';
import Layout from './Components/Layout.js';
import Layoutnotfound from './Components/Layoutnotfound.js';
import {store} from './Redux/store.js';
import { Provider } from 'react-redux';

import { ToastContainer } from 'react-toastify';
import 'react-toastify/dist/ReactToastify.css';

function App() {
  const [user, setUser] = useState();
  useEffect(()=>{
    const lsUser = localStorage.getItem('user');
    if(lsUser){
      setUser(JSON.parse(lsUser));
    }
    else{
      setUser(null)
    }
  },[]);

  return (
    <div>
   <Provider store={store}>
    <Router>
      <Routes>

        <Route path="/login" element={ <Login />}/>
        <Route path="/signup" element={<Signup />}/>
        <Route element={<Layoutnotfound/>}>
          <Route path="*" element={<PageNotFound />} />
        </Route>
        <Route element={<Layout />}>
          <Route path="/" element={<Dashboard />}/>
          <Route path="/dashboard" element={<Dashboard />}/>
        </Route>
   
      </Routes>
    </Router>
    </Provider>
    <ToastContainer />
    </div>
  );
}

export default App;
