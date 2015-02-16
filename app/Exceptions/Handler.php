<?php namespace Mrcore\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler {

	/**
	 * A list of the exception types that should not be reported.
	 *
	 * @var array
	 */
	protected $dontReport = [
		'Symfony\Component\HttpKernel\Exception\HttpException'
	];

	/**
	 * Report or log an exception.
	 *
	 * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
	 *
	 * @param  \Exception  $e
	 * @return void
	 */
	public function report(Exception $e)
	{
		#var_dump($e);
		#var_dump($e['statusCode']);
		#exit();
		return parent::report($e);
	}

	/**
	 * Render an exception into an HTTP response.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Exception  $e
	 * @return \Illuminate\Http\Response
	 */
	public function render($request, Exception $e)
	{
        if ($this->isHttpException($e)) {

        	// FIX...I could if 401 redirec to login if not authenticated
        	// but see my support macros, how I set referer...need to get all that working later
        	if ($e->getStatusCode() == 401) {
        		if (!\Auth::check()) {
        			// ?? cannot return from here
        			#return view('auth.login');
        			#return redirect('auth/login'); #this works
        		}
        		//if not logged in, redirect to login page...make sure referrer works....
        	}
            return $this->renderHttpException($e);
        }

        if (config('app.debug')) {
        	// See http://mattstauffer.co/blog/bringing-whoops-back-to-laravel-5
            return $this->renderExceptionWithWhoops($e);
        }

        return parent::render($request, $e);		
	}

    /**
     * Render an exception using Whoops.
     *
     * @see http://mattstauffer.co/blog/bringing-whoops-back-to-laravel-5
     * @param  \Exception $e
     * @return \Illuminate\Http\Response
     */
    protected function renderExceptionWithWhoops(Exception $e)
    {
        $whoops = new \Whoops\Run;
        $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler());

        return new \Illuminate\Http\Response(
            $whoops->handleException($e),
            $e->getStatusCode(),
            $e->getHeaders()
        );
    }	

}
