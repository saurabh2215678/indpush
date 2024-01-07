import React, { useEffect,useState } from 'react';
import Header from './Components/Leftpanel';
import Nav from './Components/Nav';
import { BrowserRouter as Router, Route, Routes } from 'react-router-dom';
import Login from './Pages/Login.js';
import Signup from './Pages/Signup.js';
import Dashboard from './Pages/Dashboard.js';
import PageNotFound from './Pages/PageNotFound.js';
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
  },[])

  return (
    <div>
    <Router>
      <Routes>
        {/* Route for the login page */}
        <Route exact path="/" element={ <>
              {/* Nav is always visible on other pages */}
              <Nav />
              <div className="container-fluid">
                <div className="row">
                  {/* Header and Login are visible on other pages */}
                  <Header setUser={setUser} user={user} />
                  <Dashboard />
                </div>
              </div>
            </>} />
        <Route
              path="*"
              element={<PageNotFound />}
          />
        <Route
          path="/login"
          element={
            <>
              {/* Nav is always visible */}
                    <Login setUser={setUser} user={user} />
                 
            </>
          }
        />
        {/* Other routes */}
        <Route
          path="/signup"
          element={
            <>
              {/* Nav is always visible */}
              <Signup setUser={setUser} user={user}  />
            </>
          }
        />
        {/* Other routes */}

        <Route
          path="/dashboard"
          element={
            <>
              {/* Nav is always visible on other pages */}
              <Nav />
              <div className="container-fluid">
                <div className="row">
                  {/* Header and Login are visible on other pages */}
                  <Header setUser={setUser} user={user}  />
                  <Dashboard />
                </div>
              </div>
            </>
          }
        />
        
        <Route
          path="/*"
          element={
            <>
              {/* Nav is always visible on other pages */}
              <Nav />
              <div className="container-fluid">
                <div className="row">
                  {/* Header and Login are visible on other pages */}
                  <Header setUser={setUser} user={user}  />
                  <Dashboard />
                </div>
              </div>
            </>
          }
        />
      </Routes>
    </Router>
    <ToastContainer />
    </div>
  );
}

export default App;
