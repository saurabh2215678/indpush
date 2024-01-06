import React from 'react';
import Header from './Components/Leftpanel';
import Nav from './Components/Nav';
import { BrowserRouter as Router, Route, Routes } from 'react-router-dom';
import Login from './Pages/Login.js';
import Signup from './Pages/Signup.js';
import Dashboard from './Pages/Dashboard.js';
import PageNotFound from './Pages/PageNotFound.js';

function App() {
  return (
    <Router>
      <Routes>
        {/* Route for the login page */}
        <Route exact path="/" element={ <>
              {/* Nav is always visible on other pages */}
              <Nav />
              <div className="container-fluid">
                <div className="row">
                  {/* Header and Login are visible on other pages */}
                  <Header />
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
                    <Login />
                 
            </>
          }
        />
        {/* Other routes */}
        <Route
          path="/signup"
          element={
            <>
              {/* Nav is always visible */}
              <Signup />
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
                  <Header />
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
                  <Header />
                  <Dashboard />
                </div>
              </div>
            </>
          }
        />
      </Routes>
    </Router>
  );
}

export default App;
